<?php

namespace App\Http\Controllers\Api\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\CreatePostRequest;
use App\Models\Post;
use App\Services\PostService;
use App\Traits\GetRequestType;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Resources\Post\PostResource;




class PostController extends Controller
{
    use GetRequestType;

    public function __construct()
    {
        $this->middleware('auth.jwt')->except(['index']);
    }

    public function index() {
        $posts = PostService::retrievePost();
        return $this->getFullPost($posts)->additional([
            'message' => 'Post successfully retrieved',
            'status' => 'success'
        ]);
    }

    public function store(CreatePostRequest $request) {
        try {
            if(!$post = $request->createPost()) {
                return response()->errorResponse('Failed to create post! Please try again later');
            }

            return (new PostResource($post))->additional([
                'message' => 'Post successfully created',
                'status' => 'success'
            ]);
        } catch(QueryException $e) {
            report($e);
            return response()->errorResponse('Failed to create post! Please try again later');
        }
    }

    public function show(Post $post) {

        return $this->getSimplePost($post)->additional([
            'message' => 'Post successfully retrieved',
            'status' => 'success'
        ]);
    }
    public function postlist(Post $post) {
        $post = PostService::retrieveMyPost();
        return $this->getMypost($post)->additional([
            'message' => 'My Post successfully retrieved',
            'status' => 'success'
        ]);
    }

    public function update(CreatePostRequest $request, Post $post) {
        $user = auth()->user();
        if($post->user_id !== $user->id) return response()->errorResponse('Permission Denied', [], 403);

        if(!$update_post = $post->update(
            $request->validated()
        )) {
            return response()->errorResponse('Post Update Failed');
        }

        return (new PostResource($post))->additional([
            'message' => 'Post successfully updated',
            'status' => 'success'
        ]);
    }

    public function destroy(Post $post) {
        $user = auth()->user();
        if($post->user_id !== $user->id) return response()->errorResponse('Permission Denied', [], 403);

        if(!$post->delete()) {
            return response()->errorResponse('Failed to delete post');
        }

        return response()->success('Post deleted successfully');
    }
}
