<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Helpers\ResourceHelpers;
use App\Jobs\SendActivationCodeJob;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Repositories\OTP\OTPInterface;
use App\Services\Auth\AuthenticateUser;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\OtpValidationRequest;
use App\Http\Requests\Auth\CreateNewUserRequest;
use App\Http\Requests\Auth\PasswordResetRequest;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use App\Http\Requests\OTP\ActivationCodeValidationRequest;

class AuthController extends Controller
{
    public $activation_code, $profileService;
    public function __construct(OTPInterface $activation_code)
    {
        $this->middleware('auth.jwt')->only('resendCode', 'verifyAccount', 'logout', 'authenticatedUser');
        $this->activation_code = $activation_code;
    }

    public function authenticate(LoginRequest $request)
    {
        if(auth('api')->check()) {
            auth('api')->logout();
        };

        return $request->authenticate();

    }
    
    public function refreshToken() {
        try {
            if(!$token = auth('api')->refresh()) {
                return response()->errorResponse('Unable to refresh token');
            }
            $user = auth('api')->user();
            return ResourceHelpers::returnAuthenticatedUser($user, "User Token successfully refreshed");
        } catch(TokenBlacklistedException $e) {
            return response()->errorResponse('Token has already been refreshed and invalidated', ["token" => $e->getMessage()]);
        } catch (TokenInvalidException $e) {
            return response()->errorResponse('Token has already been refreshed and invalidated', ["token" => $e->getMessage()]);            
        } catch (JWTException $e) {
            return response()->errorResponse('Please pass a bearer token', ["token" => $e->getMessage()]);
    
        }
        
    }

    public function createUser(CreateNewUserRequest $request)
    {
        $new_user = User::create($request->validated());
        
        // Send activation code via email
        SendActivationCodeJob::dispatch($new_user);

        return ResourceHelpers::returnUserData($new_user);
    }

    public function authenticatedUser() {
        return getAuthenticatedUser();
    }

    public function resendCode() {
        $user = auth('api')->user();
        if($user->email_verified_at == null) {
            SendActivationCodeJob::dispatch($user);
            // $this->activation_code->send();
            return response()->success("Activation code sent to user's email");
        }

        return response()->success("User account already activated");
    }

    public function verifyAccount(ActivationCodeValidationRequest $request) {
       return $request->activateUserAccount();        
    }

    public function forgotPassword(Request $request) {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink(
            $request->only('email')
        );
        return $status === Password::RESET_LINK_SENT
                    ? response()->success(__($status))
                    : response()->errorResponse(__($status));
    }


    public function resetPassword(PasswordResetRequest $request) {
        return $request->resetPassword();
    }

    public function logout() {
        if(auth('api')->check()) {
            auth('api')->logout();
            return response()->success('Session ended! Log out was successful');
        };
       return response()->errorResponse('You are not logged in', [], 401);
    }
}
