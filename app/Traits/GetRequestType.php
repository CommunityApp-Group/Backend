<?php

namespace App\Traits;

use App\Http\Resources\Accommodation\AccommodationResource;
use App\Http\Resources\Accommodation\AccommodationsResourceCollection;
use App\Http\Resources\Auction\AuctionResource;
use App\Http\Resources\Auction\AuctionResourceCollection;
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\Post\PostResourceCollection;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductResourceCollection;
use App\Http\Resources\Product\ProductshowResource;


trait GetRequestType
{
    public function getUserDetail($user)
    {
        // if(request()->has('fullDetails') && request('fullDetails') === 'true') {
        //     $retrieved_user = $user->with('company', 'userProfile')->jsonPaginate();
        //     return UserResourceCollection::collection($retrieved_user);
        // }

        // return UserResource::collection($user->jsonPaginate());
    }

    public function getSimpleUser($user)
    {
        // if(request()->has('fullDetails') && request('fullDetails') === 'true') {
        //     // return new UserResourceCollection($new_user);
        // }

        // return new UserResource($user->firstOrFail());
    }

    //Auction Request
    public function getSimpleAuction($auction)
    {
        //dd($auction);
        if (request()->has('fullDetails') && request('fullDetails') === 'true') {
            $auction = $auction->with('user', 'verifiedBy')->firstOrFail();
            return new AuctionResourceCollection($auction);
        }

        return new AuctionResource($auction->firstOrFail());
    }

    public function getFullAuction($auction)
    {
        if (request()->has('fullDetails') && request('fullDetails') === 'true') {
            $auction = $auction->with('user', 'verifiedBy')->paginate(20);
            return AuctionResourceCollection::collection($auction);
        }
        return AuctionResource::collection($auction->with('verifiedBy')->paginate(20));
    }

    public function getMyAuction($auction)
    {
        if (request()->has('fullDetails') && request('fullDetails') === 'true') {
            $auction = $auction->paginate(20);

            return AuctionResourceCollection::collection($auction);
        }
        return AuctionResource::collection($auction->paginate(20));
    }

    //Post Request
    public function getSinglePost($post)
    {
        if (request()->has('fullDetails') && request('fullDetails') === 'true') {
            return new PostResourceCollection($post->postcomment);
        }
        return new PostResourceCollection($post);
    }

//    public function getFullPost($post)
//    {
//        if (request()->has('fullDetails') && request('fullDetails') === 'true') {
//            $post = $post->paginate(10);
//
//            return PostResourceCollection::collection($post);
//        }
//        return PostResource::collection($post->paginate(10));
//    }

//
    public function getMypost($post)
    {
        if (request()->has('fullDetails') && request('fullDetails') === 'true') {
            $post = $post->paginate(10);

            return PostResourceCollection::collection($post);
        }
        return PostResource::collection($post->paginate(10));
    }

    public function getPopularPost($post)
    {
        if (request()->has('fullDetails') && request('fullDetails') === 'true') {
            $post = $post->paginate(10);

            return PostResourceCollection::collection($post);
        }
        return PostResource::collection($post->paginate(10));
    }


    //Product
    public function getSingleProduct($product)
    {
        if (request()->has('fullDetails') && request('fullDetails') === 'true') {
            return new ProductResourceCollection($product);

        }
        return new ProductshowResource($product);
    }

    public function getMyProduct($product)
    {
        if (request()->has('fullDetails') && request('fullDetails') === 'true') {
            return ProductResourceCollection::collection($product);
        }
        return ProductResource::collection($product->paginate(10));
    }

    public function getPopularProduct($product)
    {
        if (request()->has('fullDetails') && request('fullDetails') === 'true') {
            $product = $product->paginate(10);

            return ProductResourceCollection::collection($product);
        }
        return ProductResource::collection($product->paginate(10));
    }

       // Accommodation
    public function getSingleAccommodation($accommodation)
    {
        if (request()->has('fullDetails') && request('fullDetails') === 'true') {
            return new AccommodationsResourceCollection($accommodation);
        }
        return new AccommodationResource($accommodation);
    }

    public function getMyAccommodation($accommodation)
    {
        if (request()->has('fullDetails') && request('fullDetails') === 'true') {
            return AccommodationsResourceCollection::collection($accommodation);
        }
        return AccommodationResource::collection($accommodation->paginate(5));
    }

    public function getPopularAccommodation($accommodation)
    {
        if (request()->has('fullDetails') && request('fullDetails') === 'true') {
            $accommodation = $accommodation->paginate(10);

            return AccommodationsResourceCollection::collection($accommodation);
        }
        return AccommodationResource::collection($accommodation->paginate(10));
    }
}
