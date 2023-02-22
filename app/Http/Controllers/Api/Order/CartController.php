<?php

namespace App\Http\Controllers\Api\Order;

use DB;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\Order\CartitemResource;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.jwt');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $path = env('FILE_BASE_URL');
        $cart_items = DB::table('products')
            ->select(['products.*',DB::raw("CONCAT('".$path."',products.product_image) as image"),'carts.id as cartId','carts.quantity as cartQuantity'])
            ->join('carts','carts.product_id','=','products.id')
            ->where('carts.user_id',$user_id)
            ->where( 'carts.deleted_at',  '=',Null)->get();


        if($cart_items ->count()==0){
            $results = [
                'message' => 'Your Cart is Empty'
            ];

            return response($results,200);
        }else{
            $results = [
                'message' => 'cart item list',
                'cart items' => $cart_items
            ];

            return response($results,200);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer'
        ]);
        $user_id = auth()->user()->id;
        $exist = Cart::where('user_id',$user_id)->where('product_id',$request->product_id)->get()->first();

        if($exist){
            return response(['message'=>'Product already added to cart'],200);
        }
        $product = DB::table('products')->find($request->product_id);

        if(!$product){
            return response(['message'=>'Product not found'],404);
        }
             $cart = Cart::create([
            'user_id' => $user_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'subtotal' => $product->product_price*$request->quantity


        ]);

        $results = [
            'message' => 'Successfully added item to cart',
            'cart' => new CartitemResource($cart)
        ];

        return response($results,201);
    }

    /**
     * Display the specified resource.
     *
     * @param Cart $cart
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Cart $cart, Request $request)
    {
//
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Cart $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {

        $request->validate([
            'quantity' => 'required|integer'
        ]);

        $user_id = auth()->user()->id;

        $cart = Cart::where('user_id',$user_id)->where('id',$cart->id)->get()->first();

        if(!$cart){
            return response(['message'=>'cart product not found'],404);
        }

        $product = DB::table('products')->find($cart->product_id);
        if(!$product){
            return response(['message'=>'Product not found'],404);
        }

        $cart->update([
            'quantity' => $request->quantity,
            'subtotal' => $product->product_price*$request->quantity
        ]);


        $results = [
            'message' => 'Successfully Update item Quantity',
            'cart' => new CartitemResource($cart)
        ];

        return response($results,201);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Cart $cart
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function destroy(Cart $cart)
    {
        $user_id = auth()->user()->id;
        $cart = Cart::where('user_id',$user_id)->where('id',$cart->id)->get()->first();

        if(!$cart){
            $results = [ 'message' => 'cart item not found' ];
            return response($results,404);
        }
        $cart->delete();
        $results = [ 'message' => 'Successfully deleted the cart item' ];
        return response($results,200);
    }

}
