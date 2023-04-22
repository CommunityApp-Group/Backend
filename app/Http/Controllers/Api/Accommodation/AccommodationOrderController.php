<?php

namespace App\Http\Controllers\Api\Accommodation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accommodation\OrderRequest;
use App\Http\Resources\Accommodation\AccommodationOrderResource;
use App\Models\AccommodationOrder;
use Illuminate\Http\Request;

class AccommodationOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {

      //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(OrderRequest $request)
    {
         $request->validated();
        $user_id = auth()->user()->id;
        AccommodationOrder::create([
            'user_id' => $user_id,
            'accommodation_id' => $request['accommodation_id'],
            'note' => $request['note']
        ]);

        return response()->json([
            'message' => 'Order created successfully'
        ], 201);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return AccommodationOrderResource
     */
    public function show(AccommodationOrder $accommodationOrder)
    {
//        $accommodationOrder->load('accommodation');
        return New AccommodationOrderResource($accommodationOrder);

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
     * @param AccommodationOrder $accommodationOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccommodationOrder $accommodationOrder)
    {
        $user_id = auth()->user()->id;
        $order = AccommodationOrder::where('user_id',$user_id)->where('order_no', $accommodationOrder->order_no)
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
