<?php

namespace App\Http\Requests\Auth;

use App\Http\Resources\Admin\AdminResource;
use Illuminate\Support\Str;
use App\Helpers\ResourceHelpers;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AdminLoginRequest extends FormRequest
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
            'username' => 'required|string',
            'password' => 'required|string',
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return AdminResource
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate()
    {
        $this->ensureIsNotRateLimited();

        if (! auth('admin')->attempt($this->only($this->findUsername(), 'password'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                $this->findUsername() => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        $admin = auth('api')->user();

        return ResourceHelpers::returnAdminData($admin);

    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited()
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            $this->findUsername() => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::lower($this->findUsername()).'|'.$this->ip();
    }

    /**
     * Get the login username to be used by the authenticator.
     *
     * @return string
     */
    public function findUsername()
    {
        $login = request()->input('username');
 
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
 
        request()->merge([$fieldType => $login]);
 
        return $fieldType;
    }
}
