<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class CreateNewAdminRequest extends FormRequest
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
                 'name' => 'required|string|max:255',
                 'phone'    => 'required|required|digits:11|unique:admins',
                 'location' => 'required|string|max:255',
                 'status'    => 'nullable','in:super_admin,admin',
                 'email' => 'required|string|email|max:255|unique:admins',
                 'password' => ['required','string',
                     'confirmed',
                     'min:8', // must be a minimum of 8
                     'regex:/[a-z]/',
                     'regex:/[A-Z]/',
                     'regex:/[0-9]/',
                     'regex:/[@$!%*#?&]/',
                 ]
             ];
    }
}
