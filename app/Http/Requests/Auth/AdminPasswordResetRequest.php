<?php

namespace App\Http\Requests\Auth;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Http\FormRequest;

class AdminPasswordResetRequest extends FormRequest
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
            'email' => 'required|string|email',
            'password' => ['required',
                            'string',
                            'confirmed',
                            'min:8', // must be a minimum of 8
                            'regex:/[a-z]/',
                            'regex:/[A-Z]/',
                            'regex:/[0-9]/',
                            'regex:/[@$!%*#?&]/',
            ],
            'token' => 'required'
        ];
    }

    public function resetPassword() {
        $admin_data = $this->validated();

        $status = Password::reset(
            $admin_data,
            function ($admin, $password) {
                $admin->forceFill([
                    'password' => Hash::make($password)
                ])->save();
    
                $admin->setRememberToken(Str::random(60));
    
                event(new PasswordReset($admin));
            }
        );
    
        return $status == Password::PASSWORD_RESET
                    ? response()->success(__($status))
                    : response()->errorResponse(__($status));
    }
}
