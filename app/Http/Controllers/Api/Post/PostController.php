<?php

namespace App\Http\Controllers\Api\Post;



use App\Models\Post;
use Illuminate\Http\Request;
use App\Services\PostService;
use App\Traits\GetRequestType;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Http\Resources\Post\PostResource;
use App\Http\Requests\Post\CreatePostRequest;

class PostController extends Controller
{
    use GetRequestType;

    public function __construct()
    {
        $this->middleware('auth.jwt')->except(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index() {
        $posts = PostService::retrievePost();
        return $this->getFullPost($posts)->additional([
            'message' => 'Post successfully retrieved',
            'status' => 'success'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return PostResource
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int  $post
     * @return PostResource|\App\Http\Resources\Post\PostResourceCollection
     */
    public function show(Post $post) {

        return $this->getSimplePost($post)->additional([
            'message' => 'Post successfully retrieved',
            'status' => 'success'
        ]);
    }

    /**
     * Display a listing of the Current User resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function postlist(Post $post) {
        $post = PostService::retrieveMyPost();
        return $this->getMypost($post)->additional([
            'message' => 'My Post successfully retrieved',
            'status' => 'success'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return PostResource
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post) {
        $user = auth()->user();
        if($post->user_id !== $user->id) return response()->errorResponse('Permission Denied', [], 403);

        if(!$post->delete()) {
            return response()->errorResponse('Failed to delete post');
        }

        return response()->success('Post deleted successfully');
    }
}
