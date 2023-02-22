<?php

namespace App\Http\Controllers\Api\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostReviewRequest;
use App\Http\Resources\Post\PostCommentResource;
use App\Models\Post;
use App\Models\Postcomment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $post = Post::with('user:id,name')
            ->withCount('postreviews')
            ->latest()
            ->paginate(20);
        return PostCommentResource::collection($post->reviews);
        return PostCommentResource::collection(Post::with('comment')->paginate(25));
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
     * @param PostReviewRequest $request
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function store(PostReviewRequest $request, Post $post)
    {
        $review = new Postcomment($request->all());
        $review->user_id = $user = auth()->user()->id;
        $post->reviews()->save($review);
        return response([
            'data' => new PostCommentResource($review)
        ],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Postcomment  $postreview
     * @return \Illuminate\Http\Response
     */
    public function show(Postcomment $postreview)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Postcomment  $postreview
     * @return \Illuminate\Http\Response
     */
    public function edit(Postcomment $postreview)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Postcomment  $postreview
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post, Postcomment $postreview)
    {
        $postreview->update($request->all());
        return response([
            'data' => new PostCommentResource($postreview)
        ],Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Postcomment  $postreview
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post, Postcomment $postreview)
    {
        $postreview->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }
}
