<?php

namespace App\Http\Controllers\Api\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostCommentRequest;
use App\Http\Resources\Post\PostCommentResource;
use App\Http\Resources\Post\PostcommentResourceCollection;
use App\Models\Post;
use App\Models\Post_comment;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostCommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth.jwt');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $posts = Post::with('postcomment')
            ->withcount('postcomment')
            ->latest()
            ->paginate(20);
        return PostcommentResourceCollection::collection($posts);
//        $results = [
//            'message' => 'All Post with COmments ',
//            'Post' => $posts
//        ];
//
//        return response($results, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostCommentRequest $request
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function store(PostCommentRequest $request, Post $post)
    {
        $user = auth()->user()->id;
        $comment = new Post_comment($request->all());
        $comment->user_id =$user;
        $post->postcomment()->save($comment);

        $results = [
                'message' => 'Comment Posted',
                'Post' => new PostCommentResource($comment)
            ];

            return response($results, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Postcomment $postcomment
     * @return void
     */
    public function show( Postcomment $postcomment)
    {
//
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Postcomment  $postcomment
     * @return \Illuminate\Http\Response
     */
    public function edit(Postcomment $postcomment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Postcomment  $postcomment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post, Postcomment $postcomment)
    {
        $postcomment->update($request->all());
        return response([
            'data' => new PostCommentResource($postcomment)
        ],Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Postcomment  $postcomment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post, Postcomment $postcomment)
    {
        $postcomment->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }
}
