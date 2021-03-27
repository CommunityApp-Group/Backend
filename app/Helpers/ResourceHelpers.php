<?php

namespace App\Helpers;

use App\Http\Resources\Auth\UserResource;

class ResourceHelpers {
    public static function returnUserData($user) : UserResource {
        return (new UserResource($user))->additional([
            'message' => 'Successfully returned user data',
            'status' => "success"
        ]);
    }
}