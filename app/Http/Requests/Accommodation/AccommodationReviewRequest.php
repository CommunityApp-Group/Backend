<?php

namespace App\Http\Requests\Accommodation;

use App\Rules\ValidateValidAmount;
use Illuminate\Foundation\Http\FormRequest;

class AccommodationReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $data =  [
            "customer"  => ['required', 'string', 'max:255'],
            "star"   => ['required','integer','between:0,5'],
            "review"    => ['required'],
        ];


        return $data;
    }

    public function createAccommodationReview() {
        $user = auth()->user();
        $data = $this->validated();

        return $user->accommodation()->create($data);
    }
}
