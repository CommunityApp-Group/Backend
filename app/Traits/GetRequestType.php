<?php

namespace App\Traits;

use App\Http\Resources\Auction\AuctionResource;
use App\Http\Resources\Auction\AuctionResourceCollection;


trait GetRequestType {
    public function getUserDetail($user) {
        // if(request()->has('fullDetails') && request('fullDetails') === 'true') {
        //     $retrieved_user = $user->with('company', 'userProfile')->jsonPaginate();
        //     return UserResourceCollection::collection($retrieved_user);
        // }
        
        // return UserResource::collection($user->jsonPaginate());
    }
    
    public function getSimpleUser($user) {
        // if(request()->has('fullDetails') && request('fullDetails') === 'true') {
        //     // return new UserResourceCollection($new_user);
        // }
        
        // return new UserResource($user->firstOrFail());
    }

    public function getSimpleAuction($auction) {
        if(request()->has('fullDetails') && request('fullDetails') === 'true') {
            $auction = $auction->with('user', 'verifiedBy')->firstOrFail();
            return new AuctionResource($auction);
        }
        
        return new AuctionResource($auction->firstOrFail());
    }
    public function getFullAuction($auction) {
        if(request()->has('fullDetails') && request('fullDetails') === 'true') {
            $auction = $auction->with('user', 'verifiedBy')->paginate(20);
            return AuctionResourceCollection::collection($auction);
        }
        return AuctionResource::collection($auction->with('verifiedBy')->paginate(20));
    }

}