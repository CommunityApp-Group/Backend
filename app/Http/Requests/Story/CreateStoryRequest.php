<?php

namespace App\Http\Requests\Story;

use App\Models\Story;
use Illuminate\Foundation\Http\FormRequest;

class CreateStoryRequest extends FormRequest
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
            "storyline"   => ['nullable'],
            "story_image"  => ['required'],
        ];

        if($this->filled('story_image'))
        foreach($this->input('story_image') as $index => $photo) {
            if(photoType($photo)) {
                $data['story_image'.$index] = photoType($photo) == "file" ? 'image|mimes:jpeg,jpg,png,gif,webp' : 'base64image|base64mimes:jpeg,jpg,png,gif,webp';
            }
        }

        return $data;
    }

    public function createStory() {
        $user = auth()->user();
        $data = $this->validated();

        return $user->story()->create($data);
    }

    protected function getPhotoType() {
        if ($this->filled('story_image')) {
            return photoType($this->input('story_image'));
        } elseif($this->file('story_image')) {
            return photoType($this->file('story_image'));
        }
    }

    public function messages()
    {
        return [
            'story_image.*.required' => 'Story image is required'
        ];
    }
}
