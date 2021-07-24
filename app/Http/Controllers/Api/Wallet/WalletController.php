<?php

namespace App\Http\Controllers\Api\Wallet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Bavix\Wallet\Exceptions\AmountInvalid;
use App\Http\Requests\Wallet\DepositRequest;

class WalletController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware('auth.jwt');
        $this->user = auth('api')->user();
    }
    /**
     * Display a user wallet balance
     *
     * @return \Illuminate\Http\Response
     */
    public function balance()
    {
        // dd($this->user->wallet->meta);
        return response()->success(
            'User wallet balance retrieved successfully',
            ['balance' => $this->user->balanceFloat]
        );
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deposit(DepositRequest $request)
    {
        $step1 = session()->get($this->user->encodedKey);

        dd($step1);

        try {
            $amount = $request->amount;
            if(!$this->user->depositFloat($amount)) {
                return response()->errorResponse(
                    'Error funding user wallet'
                );
            }
            return response()->success(
                'User wallet funded successfully',
                ['balance' => $this->user->balanceFloat]
            );
        } catch (AmountInvalid $e) {
            return response()->errorResponse($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
