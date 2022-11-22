<?php

namespace App\Http\Requests\Post;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
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
            "title"   => ['required', 'string', 'max:255'],
            "category_name" => ['required', 'exists:categories,name'],
            "postline"   => ['required'],
            "post_image"  => ['nullable'],
        ];

        if($this->filled('post_image'))
        foreach($this->input('post_image') as $index => $photo) {
            if(photoType($photo)) {
                $data['post_image'.$index] = photoType($photo) == "file" ? 'image|mimes:jpeg,jpg,png,gif,webp' : 'base64image|base64mimes:jpeg,jpg,png,gif,webp';
            }
        }

        return $data;
    }

    public function createPost() {
        $user = auth()->user();
        $data = $this->validated();

        return $user->post()->create($data);
    }

    protected function getPhotoType() {
        if ($this->filled('post_image')) {
            return photoType($this->input('post_image'));
        } elseif($this->file('post_image')) {
            return photoType($this->file('post_image'));
        }
    }

    public function messages()
    {
        return [
            'post_image.*.required' => 'Post image is required'
        ];
    }
}
