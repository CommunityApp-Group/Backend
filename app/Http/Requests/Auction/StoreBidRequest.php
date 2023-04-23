<?php

namespace App\Http\Requests\Auction;

use App\Rules\BalanceMoreThenUserBids;
use App\Rules\GreaterThanMaxBid;
use Illuminate\Foundation\Http\FormRequest;

class StoreBidRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'auction' => [
                'required',
                'numeric',
                'integer',
            ],
            'bid' => [
                'required',
                'numeric',
                'integer',
                'min:1',
                new GreaterThanMaxBid($this->auction),
//                new BalanceMoreThenUserBids
            ]
        ];
    }
}
