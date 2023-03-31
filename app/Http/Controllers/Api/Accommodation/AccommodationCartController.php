<?php

namespace App\Http\Controllers\Api\Accommodation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accommodation\CartRequest;
use App\Models\AccommodationCart;
use App\Models\CartAccommodationDetail;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Contracts\Providers\Auth;

class AccommodationCartController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CartRequest $request)
    {
        $data = $request->validated();

            $user = auth()->user();

        $cart = AccommodationCart::create([ 'user_id' => isset($user) ? $user->id : NULL ]);

        if(isset($data['productId'])) {
            CartAccommodationDetail::create([
                'cart_id' => $cart->id,
                'accommodation_id' => $data['accommodation_id'],
                'quantity' => $data['quantity']
            ]);
            $message = 'Cart created successfully with accommodation';
        }

        return response()->json([
            'message' => $message ?? 'Cart created successfully with no accommodation',
            'cartId' => $cart->id,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
