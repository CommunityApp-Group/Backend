<?php

namespace App\Traits;

use App\Http\Resources\Post\PostResource;
use App\Http\Resources\Post\PostResourceCollection;


trait GetRequestType
{

    public function getSimplePost($post)
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
            $post = $post->with('user')->paginate(20);
            return PostResourceCollection::collection($post);
        }
        return  PostResource::collection($post->with()->paginate(20));
    }

    public function getMyPost($post)
    {
        if (request()->has('fullDetails') && request('fullDetails') === 'true') {
            $post = $post->paginate(20);

            return PostResourceCollection::collection($post);
        }

        return  PostResource::collection($post->with()->paginate(20));
    }
}
