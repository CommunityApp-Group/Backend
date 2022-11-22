<?php


namespace App\Http\Requests\Auth;


use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            "firstname"  => ['required', 'string', 'max:155'],
            "lastname"   => ['required', 'string', 'max:155'],
            "location"    => ['required'],
            "username"    => ['required', 'string', 'max:155'],
            'gender'    => ['required|in:male,female'],
            "avatar"      => ['nullable', 'image', 'max:4096'],
            "bio"      => ['nullable'],
            "dob"       => ['nullable'],
            "website"      => ['nullable'],
            "country"       => ['nullable'],
            "city"      => ['nullable'],
            "postcode"       => ['nullable'],
            "state"       => ['nullable'],
            "billing_address"      => ['nullable'],
        ];


        if($this->filled('cover'))
            foreach($this->input('cover') as $index => $photo) {
                if(photoType($photo)) {
                    $data['cover'.$index] = photoType($photo) == "file" ? 'image|mimes:jpeg,jpg,png,gif,webp' : 'base64image|base64mimes:jpeg,jpg,png,gif,webp';
                }

            }
        if($this->filled('avatar'))
            foreach($this->input('avatar') as $index => $photo) {
                if(photoType($photo)) {
                    $data['avatar'.$index] = photoType($photo) == "file" ? 'image|mimes:jpeg,jpg,png,gif,webp' : 'base64image|base64mimes:jpeg,jpg,png,gif,webp';
                }

            }

        return $data;
    }


    protected function getPhotoType() {
        if ($this->filled('avatar')) {
            return photoType($this->input('avatar'));
        } elseif($this->file('avatar')) {
            return photoType($this->file('avatar'));
        }
    }

    public function messages()
    {
        return [
            'Avatar.*.required' => 'Avatar image is required'
        ];
    }
}