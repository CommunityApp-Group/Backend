<?php

namespace App\Http\Requests\Accommodation;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
//        if($this->route()->getName() === 'accommodations/cart.store')
//            return true;
//
//        $cartUser = $this->route('accommodations/cart')->user_id ?? NULL;
//        $userId = auth()->user()->id ?? NULL;
//        return $cartUser === $userId;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'accommodationId' => 'sometimes|exists:accommodations,id',
            'quantity' => 'sometimes|numeric|min:1|max:20|required_with:accommodationId'
        ];
    }
}
