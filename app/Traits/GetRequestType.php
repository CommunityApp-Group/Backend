<?php

namespace App\Traits;

use App\Http\Resources\Auction\AuctionResource;
use App\Http\Resources\Auction\AuctionResourceCollection;
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\Post\PostResourceCollection;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductResourceCollection;
use App\Models\Post;

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
        return  AuctionResource::collection($auction->with('verifiedBy')->paginate(20));
    }

    public function getMyAuction($auction)
    {
        if (request()->has('fullDetails') && request('fullDetails') === 'true') {
            $auction = $auction->paginate(20);

            return AuctionResourceCollection::collection($auction);
        }
        return  AuctionResource::collection($auction->paginate(20));
    }

    //Post Request
    public function getSinglePost($post)
    {
        if (request()->has('fullDetails') && request('fullDetails') === 'true') {
            $post = $post->with('user')->firstOrFail();
            return new PostResourceCollection($post);
        }

        return new PostResource($post->firstOrFail());
    }

    public function getFullPost($post)
    {
        if (request()->has('fullDetails') && request('fullDetails') === 'true') {
            $post = $post->paginate(10);

            return PostResourceCollection::collection($post);
        }

        return  PostResource::collection($post->paginate(20));
    }
//
    public function getMypost($post)
    {
        if (request()->has('fullDetails') && request('fullDetails') === 'true') {
            $post = $post->paginate(10);

            return PostResourceCollection::collection($post);
        }

        return  PostResource::collection($post->paginate(10));
    }

    public function getPopularPost($post)
    {
        if (request()->has('fullDetails') && request('fullDetails') === 'true') {
            $post = $post->paginate(10);

            return PostResourceCollection::collection($post);
        }

        return  PostResource::collection($post->paginate(10));
    }

//    //Product
//    public function getSimpleProduct($product)
//    {
//        if (request()->has('fullDetails') && request('fullDetails') === 'true') {
//            $product = $product->with('user')->firstOrFail();
//            return new ProductResourceCollection($product);
//        }
//
//        return new ProductResource($product->firstOrFail());
//    }
//
//    public function getFullProduct($product)
//    {
//        if (request()->has('fullDetails') && request('fullDetails') === 'true')
//        {
//            $product = $product->with('user')->paginate(20);
//            return ProductResourceCollection::collection($product);
//        }
//        return  ProductResource::collection($product->with()->paginate(20));
//    }
//
//
//    public function getMyProduct($product)
//    {
//        if (request()->has('fullDetails') && request('fullDetails') === 'true') {
//            $product = $product->paginate(20);
//
//            return ProductResourceCollection::collection($product);
//        }
//
//        return  ProductResource::collection($product->paginate(20));
//    }
}
