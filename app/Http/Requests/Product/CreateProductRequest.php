<?php

namespace App\Http\Requests\Product;

use App\Models\Product;
use App\Rules\ValidateValidAmount;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            "product_name"  => ['required', 'string', 'max:255'],
            "category_name" => ['required', 'exists:categories,name'],
            "description"   => ['required'],
            "product_price" => ['required', 'numeric', new ValidateValidAmount],
            "product_image"    => ['required'],
        ];


        if($this->filled('product_image'))
            foreach($this->input('product_image') as $index => $photo) {
                if(photoType($photo)) {
                    $data['product_image'.$index] = photoType($photo) == "file" ? 'image|mimes:jpeg,jpg,png,gif,webp' : 'base64image|base64mimes:jpeg,jpg,png,gif,webp';
                }

            }

        return $data;
    }

    public function createProduct() {
        $user = auth()->user();
        $data = $this->validated();

        return $user->product()->create($data);
    }

    protected function getPhotoType() {
        if ($this->filled('product_image')) {
            return photoType($this->input('product_image'));
        } elseif($this->file('product_image')) {
            return photoType($this->file('product_image'));
        }
    }

    public function messages()
    {
        return [
            'product_image.*.required' => 'Product image is required'
        ];
    }
}
