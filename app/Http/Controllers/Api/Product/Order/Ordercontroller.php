<?php

namespace App\Http\Controllers\Api\Product\Order;

use App\Jobs\SendOrderplacedJob;
use App\Mail\OrderMail;
use DB;
use Mail;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Product\Order\OrderResource;

class Ordercontroller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.jwt');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;

        $order_products = OrderItem::select(['orders.*', 'order_items.order_id', 'order_items.price', 'order_items.quantity'])
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.user_id', $user_id)
            ->orderBy('order_items.order_id', 'desc')->get();

        if ($order_products->count() == 0) {
            $results = [
                'message' => 'You have no Order'
            ];

            return response($results, 200);
        } else {
            $results = [
                'message' => 'All order ',
                'order_products' => $order_products
            ];

            return response($results, 200);
        }


    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $items = Cart::where('user_id','=',auth()->user()->id)->get();

        if(count($items) == 0) {
            $results = [
                'message' => 'Cart is Empty'
            ];

            return response($results, 200);
        }
        try {
            DB::transaction(function ()
            {
                $totalAmount = 0;
                $cart = Cart::where('user_id','=',auth()->user()->id)->get() ;

                foreach ($cart as $item) {
                    $totalAmount += $item['subtotal'];
                }
                $amount = $totalAmount;
                $user_id = auth()->user()->id;

                $order = Order::create([
                    'user_id' => $user_id,
                    'total' => $amount,
                    ]);

                $items = Cart::where('user_id','=',auth()->user()->id)->get();


                foreach($items as $item) {
                    $order_item = OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price' => $item->subtotal
                    ]);
                    Cart::where('user_id','=',auth()->user()->id)->delete();

                }
                /*==== email send ===*/
                SendOrderplacedJob::dispatch($order);
                /*==== email send ===*/
            });

            $results = [
                'message' => 'your Order has been placed on pending please proceed to checkout'
            ];

            return response($results, 200);

        }
        catch (\Throwable $e) {
            $results = [
             'message' => $e->getMessage()
            ];

            return response($results, 500);
        }
}


    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function show(Order $order)
    {

        $orders = $order->user_id ==auth()->user()->id;

        if(!$orders){
            $results = [ 'message' => 'order not found' ];
            return response($results,404);
        }

        $order_products = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->where('order_items.order_id', '=', $order->id)
            ->select('orders.id','orders.total','orders.status','order_items.product_id','order_items.price','order_items.quantity','products.product_name','products.product_image')
            ->get();

        $results = [
            'message' => 'Your order details',
            'order' => new OrderResource($order),
            'order_products' => $order_products
        ];

        return response($results,200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $user_id = auth()->user()->id;
        $order = Order::where('user_id',$user_id)->where('order_no', $order->order_no)
            ->where('status','pending')->get()->first();

        if(!$order){
            $results = [ 'message' => 'order not found' ];
            return response($results,404);
        }

        $order->delete();
        $results = [ 'message' => 'Successfully deleted the order' ];
        return response($results,200);
    }


}