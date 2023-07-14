<?php

namespace App\Http\Controllers\Api\Post;

use App\Http\Resources\Post\PostResourceCollection;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Services\PostService;
use App\Traits\GetRequestType;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Http\Resources\Post\PostResource;
use App\Http\Requests\Post\CreatePostRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use PHPOpenSourceSaver\JWTAuth\Contracts\Providers\Auth;

class PostController extends Controller
{
    use GetRequestType;

    public function __construct()
    {
        $this->middleware('auth.jwt')->except(['index', 'show', 'search']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return PostResourceCollection::Collection(Post::latest()->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreatePostRequest $request
     * @return PostResource
     */
    public function store(CreatePostRequest $request) {
        try {
//
//    $user = auth()->user();
//
//    if (is_null($user->email_verified_at)) {
//        return response()->errorResponse('Failed to create post! Please Upload your NYSC Card for Verificatio');
//    }

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
     * @param Post $post
     * @return PostResourceCollection
     */
    public function show(Post $post)
    {
        return $this->getSinglePost($post)->additional([
            'message' => 'Post successfully retrieved',
            'status' => 'success'
        ]);

    }

    /**
     * Display a listing of the Current User resource.
     *
     * @return AnonymousResourceCollection
     */
    public function mypost(Post $post)
    {
        $user = auth()->user();
        $post = $user->post;
        return PostResource::collection($post)->additional([
            'message' => 'My Post successfully retrieved',
            'status' => 'success'
        ]);
//        $post = PostService::retrieveMyPost();
//        return $this->getMypost($post)->additional([
//            'message' => 'My Post successfully retrieved',
//            'status' => 'success'
//        ]);
    }

    /**
     * Display a listing of the Current User resource.
     *
     * @return AnonymousResourceCollection
     */
    public function popularpost(Post $post) {
        $post = PostService::retrievePopularPost();
        return $this->getPopularPost($post)->additional([
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

    /**
     * Search for a name
     *
     * @param $postline
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function search($post)
    {
        $post = Post::where('post', 'like', '%'.$post.'%')->get();
        return PostResourceCollection::collection($post);
    }
}
