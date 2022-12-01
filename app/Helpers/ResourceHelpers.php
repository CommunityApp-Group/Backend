<?php

namespace App\Helpers;

use App\Http\Resources\Auth\UserResource;
use App\Http\Resources\User\AuthUserResource;
use App\Http\Resources\User\Userprofile;
use App\Http\Resources\User\UserResourceCollection;

class ResourceHelpers
{
    /**
     * @param $user
     * @return UserResource
     */
    public static function returnUserData($user)
    {
        return (new UserResource($user))->additional([
            'message' => 'Successfully returned user data',
            'status' => "success"
        ]);
    }

    /**
     * @param $user
     * @param $message
     * @return AuthUserResource
     */
    public static function returnAuthenticatedUser($user, $message)
    {
        return (new AuthUserResource($user))->additional([
            'message' => $message,
            'status' => "success"
        ]);
    }

    /**
     * @param $user
     * @param $message
     * @return UserResourceCollection
     */
    public static function fullUserWithRoles($user, $message)
    {
        return (new UserResourceCollection($user))->additional([
            'message' => $message,
            'status' => "success"
        ]);
    }

    /**
     * @param $user
     * @param $message
     * @return UserProfile
     */
    public static function returnUserprofile($user, $message)
    {
        return (new UserProfile($user))->additional([
            'message' => 'User Profile successfully retrieved',
            'status' => "success"
        ]);
    }
}
