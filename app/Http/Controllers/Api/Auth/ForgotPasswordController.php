<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendResetpasswordJob;
use App\Models\User;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function forgotPassword(Request $request)
    { $request->validate(['email' => 'required|email']);
        $users = User::where('email', $request->email)->first();
        if (count((array)$users) < 1)
        {
            return response()->errorResponse("Email Not found, Please check again or proceed to registration page");
        }
        else
        {
            SendResetpasswordJob::dispatch($users);
            return response()->success("Password reset token sent to user's email");
        }


    }
}
