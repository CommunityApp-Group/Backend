<?php

namespace App\Traits;
use App\Http\Resources\Auth\UserResource;
use App\Http\Resources\User\UserResourceCollection;


trait GetRequestType {
    public function getUserDetail($user) {
        if(request()->has('fullDetails') && request('fullDetails') === 'true') {
            $retrieved_user = $user->with('company', 'userProfile')->jsonPaginate();
            return UserResourceCollection::collection($retrieved_user);
        }
        
        return UserResource::collection($user->jsonPaginate());
    }
    
    public function getSimpleUser($user) {
        if(request()->has('fullDetails') && request('fullDetails') === 'true') {
            // return new UserResourceCollection($new_user);
        }
        
        return new UserResource($user->firstOrFail());
    }

}