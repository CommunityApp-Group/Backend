<?php

namespace App\Http\Requests\Accommodation;

use App\models\Accommodation;
use App\Rules\ValidateValidAmount;
use Illuminate\Foundation\Http\FormRequest;

class CreateAccommodationRequest extends FormRequest
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
        $data =  [
            "title"  => ['required', 'string', 'max:255'],
            "category_name" => ['required', 'exists:categories,name'],
            "description"   => ['required'],
            "state"   => ['required'],
            "city"   => ['required'],
            "nearby"   => ['required'],
            "lga"   => ['required'],
            "type"   => ['required'],
            "address"   => ['required'],
            "accommodation_price" => ['required', 'numeric', new ValidateValidAmount],
            "accommodation_image"    => [''],
        ];


        if($this->filled('accommodation_image'))
            foreach($this->input('accommodation_image') as $index => $photo) {
                if(photoType($photo)) {
                    $data['accommodation_image'.$index] = photoType($photo) == "file" ? 'image|mimes:jpeg,jpg,png,gif,webp' : 'base64image|base64mimes:jpeg,jpg,png,gif,webp';
                }

            }

        return $data;
    }


    protected function getPhotoType() {
        if ($this->filled('accommodation_image')) {
            return photoType($this->input('accommodation_image'));
        } elseif($this->file('accommodation_image')) {
            return photoType($this->file('accommodation_image'));
        }
    }

    public function messages()
    {
        return [
            'accommodation_image.*.required' => 'Accommodation image is required'
        ];
    }
}
