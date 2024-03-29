<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
//        $category_id = $this->route('category')->id;
        return [
            "name" => "required|string|max:100|unique:categories,name,"
        ];
    }


    public function messages()
    {
        return [
            "unique" => "Category name already exist"
        ];
    }
}
