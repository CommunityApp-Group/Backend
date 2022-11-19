<?php


namespace App\Services;


use App\Models\Post;
use App\Filters\PostFilter\PostName;
use Illuminate\Contracts\Pipeline\Pipeline;

class PostService
{
    public static function retrievePost() {
        return app(Pipeline::class)
            ->send(Post::orderBy('created_at', 'DESC'))
            ->through([
                PostName::class
            ])
            ->thenReturn();
    }

    public static function retrieveMyPost() {
        return app(Pipeline::class)
            ->send(Post::where('user_id',  auth()->id()))
            ->through([ PostName::class  ])
            ->thenReturn();
    }

}