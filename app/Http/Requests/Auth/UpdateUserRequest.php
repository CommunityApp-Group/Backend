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
            "location"    => ['nullable','string'],
            "phone"    => ['nullable','required','digits:11'],
            'gender'    => ['required','in:male,female'],
            "avatar"      => ['nullable', 'image', 'max:4096'],
            "bio"      => ['nullable'],
            'dob'    => ['nullable','date','date_format:Y-m-d','before:'.now()->subYears(18)->toDateString()],
            "country"       => ['nullable'],
            "city"      => ['nullable'],
            "state"       => ['nullable'],
            "address"      => ['nullable']
        ];


        if($this->filled('avatar'))
            foreach($this->input('avatar') as $index => $photo) {
                if(photoType($photo)) {
                    $data['avatar'.$index] = photoType($photo) == "file" ? 'image|mimes:jpeg,jpg,png,gif,webp' : 'base64image|base64mimes:jpeg,jpg,png,gif,webp';
                }

            }

        return $data;
    }
    public function createProfile() {
        $user = auth()->user();
        $data = $this->validated();

        return $user->profile()->create($data);
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