<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Pipeline\Pipeline;
use App\Filters\PostFilter\PostName;
use App\Filters\PostFilter\Category;

class PostService
{
    public static function retrievePost() {
        $post_filter = app(Pipeline::class)
            ->send(Post::orderBy('created_at', 'DESC'))
            ->through([
                Category::class,
                PostName::class
            ])
            ->thenReturn();
        return $post_filter;
    }

    public static function retrieveMyPost() {
        $post_filter = app(Pipeline::class)
            ->send(Post::where('user_id',  auth()->id()))
            ->through([
                Category::class,
                PostName::class
            ])
            ->thenReturn();
        return $post_filter;
    }
}
