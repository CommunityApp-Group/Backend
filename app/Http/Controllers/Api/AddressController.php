<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\AddressCollection;
use App\Models\Address;
use App\Models\Cart;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.jwt');
    }
    /**
     * Display a listing of the resource.
     *
     * @return AddressCollection
     */
    public function index()
    {
        return new AddressCollection(Address::where('user_id', auth()->user()->id)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $address = new Address;
        $address->user_id = auth()->user()->id;
        $address->address = $request->address;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->phone = $request->phone;
        $address->save();

        return response()->json([
            'result' => true,
            'message' => 'Shipping information has been added successfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Address $address)
    {

        $address->update($request->all());
        return response()->json([
            'result' => true,
            'message' => 'Shipping information has been updated successfully'
        ]);
    }    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\JsonResponse
     */
    public function makedefault(Request $request,  Address $address)
    {
        Address::where('user_id', auth()->user()->id)->update(['set_default' => 0]); //make all user addressed non default first

        $address->set_default = 1;
        $address->update($request->all());
        return response()->json([
            'result' => true,
            'message' => 'Default shipping information has been updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy( $id)
    {
        $address = Address::where('id',$id)->where('user_id',auth()->user()->id)->first();
        if($address == null) {
            return response()->json([
                'result' => false,
                'message' => 'Address not found'
            ]);
        }
        $address->delete();
        return response()->json([
            'result' => true,
            'message' => 'Shipping information has been deleted'
        ]);
    }

    public function updateAddressInCart(Request $request)
    {
        try {
            Cart::where('user_id', auth()->user()->id)->update(['address_id' => $request->address_id]);

        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => 'Could not save the address'
            ]);
        }
        return response()->json([
            'result' => true,
            'message' => 'Address is saved'
        ]);

    }

}
