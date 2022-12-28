<?php

namespace App\Http\Controllers\Api\Profile;

use App\Models\User;
use App\Traits\GetRequestType;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\UpdateUserRequest;
use App\Http\Resources\User\UserProfile;
use App\Http\Controllers\Controller;
use PHPOpenSourceSaver\JWTAuth\Contracts\Providers\Auth;


class ProfileController extends Controller
{
    use GetRequestType;

    public function __construct()
    {
        $this->middleware('auth.jwt');
    }
    /**
     * @return \App\Http\Resources\User\UserProfile
     */
    public function index() {
        return getprofile();
    }

    public function update(UpdateUserRequest $request, User $user,  $encodedKey ) {
        $user = auth()->user();
        if($request->user()->encodedKey !== $user->encodedKey) return response()->errorResponse('Permission Denied', [], 403);

        if(!$update_profile = $user->update(
            $request->validated()
        )) {
            return response()->errorResponse('Profile Update Failed');
        }

        return (new UserProfile($user))->additional([
            'message' => 'Profile successfully updated',
            'status' => 'success'
        ]);
    }
    public function show() {

        return getprofile();
    }
}
