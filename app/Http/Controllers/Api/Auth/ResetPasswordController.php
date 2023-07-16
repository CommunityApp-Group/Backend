<?php

namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PasswordResetRequest;
use App\Http\Resources\Auth\PasswordResource;
use App\Models\Otp;
use App\Models\User;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{


    /**
     * Handle an incoming new password request.
     *
     * @param \Illuminate\Http\Request $request
     * @param Otp $otp
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     *
     */
    public function verify(Request $request, User $user, Otp $otp )
    {
        $request->validate(['token' => 'required|exists:otps,digit',]);
        $expires = Otp::where('digit', $request->token)->
        where('expires_at', '>', \Carbon\Carbon::now())->first();

        if (!$expires) {
            return response([
                'message' => trans('Error! this token has expired, get a new token ')
            ], 200);
        } else
            $results = [
                'message' => 'Valid, Enter a New Password',
//                'Password' => new PasswordResource($users)
            ];
        return response($results, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Otp $otp
     * @return PasswordResource
     */
    public function show(Otp $otp )
    {
        $token = DB::table('otps')->get();
        return new PasswordResource($otp);
    }


    public function resetPassword(Request $request)
    { $request->validate([
        'password' => ['required',
            'string',
            'confirmed',
            'min:8', // must be a minimum of 8
            'regex:/[a-z]/',
            'regex:/[A-Z]/',
            'regex:/[0-9]/',
            'regex:/[@$!%*#?&]/']
    ]);

        $validator = Validator::make($request->all(), [
            'password' => 'required|between:6,255|confirmed',
            'password_confirmation' => 'required '
        ]);

        if ($validator->fails()) {
            return ['status' => false, 'error' => $validator->errors()->all()];
        }
        $password = $request->password;

        $tokenData = DB::table('otps')->where('digit', $request->token)->first();


        $user = User::where('id', $tokenData->user_id)->first();

        $user->password = Hash::make($password);
        if ($user->update()) {

        }

        return ['status' => true, 'message' => 'Password Updated'];

    }

}
