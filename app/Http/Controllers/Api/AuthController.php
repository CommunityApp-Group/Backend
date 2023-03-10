<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\ResourceHelpers;
use App\Jobs\SendActivationCodeJob;
use App\Http\Controllers\Controller;
use App\Repositories\OTP\OTPInterface;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\Auth\CreateNewUserRequest;
use App\Http\Requests\Auth\PasswordResetRequest;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\OTP\ActivationCodeValidationRequest;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenBlacklistedException;


class AuthController extends Controller
{
    /**
     * @var OTPInterface
     */
    /**
     * @var OTPInterface
     */
    public $activation_code;
    
    public function __construct(OTPInterface $activation_code)
    {
        $this->middleware('auth.jwt')->only('resendCode', 'verifyAccount', 'logout', 'authenticatedUser');
        $this->activation_code = $activation_code;

    }

    /**
     * @param LoginRequest $request
     * @return \App\Http\Resources\Auth\UserResource
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(LoginRequest $request)
    {
        if(auth('api')->check()) {
            auth('api')->logout();
        };

        return $request->authenticate();

    }



    /**
     * @return \App\Http\Resources\User\AuthUserResource
     */
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

    /**
     * @param CreateNewUserRequest $request
     * @return \App\Http\Resources\Auth\UserResource
     */
    public function register(CreateNewUserRequest $request)
{
    $new_user = User::create($request->validated());

    // Send activation code via email
    SendActivationCodeJob::dispatch($new_user);

    return ResourceHelpers::returnUserData($new_user);
}

    /**
     * @return \App\Http\Resources\User\UserResourceCollection
     */
    public function authenticatedUser() {
        return getAuthenticatedUser();
    }

    /**
     * @return mixed
     */
    public function resendCode() {
        $user = auth('api')->user();
        if($user->email_verified_at == null) {
            SendActivationCodeJob::dispatch($user);
            return response()->success("Activation code sent to user's email");
        }
        return response()->success("User account already activated");
    }

    /**
     * @param ActivationCodeValidationRequest $request
     * @return mixed
     */
    public function verifyAccount(ActivationCodeValidationRequest $request) {
       return $request->activateUserAccount();        
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function forgotPassword(Request $request) {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink(
            $request->only('email')
        );
        return $status === Password::RESET_LINK_SENT
                    ? response()->success(__($status))
                    : response()->errorResponse(__($status));
    }


    /**
     * @param PasswordResetRequest $request
     * @return mixed
     */
    public function resetPassword(PasswordResetRequest $request) {
        return $request->resetPassword();
    }



    /**
     * @return mixed
     */
    public function logout() {
        if(auth('api')->check()) {
            auth('api')->logout();
            return response()->success('Session ended! Log out was successful');
        };
       return response()->errorResponse('You are not logged in', [], 401);
    }
}
