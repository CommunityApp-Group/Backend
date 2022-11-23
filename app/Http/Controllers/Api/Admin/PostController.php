<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{   public function __construct()
{
    $this->middleware('auth.jwt:admin');
}

    public function update(Request $request, Post $post) {
        $request->validate([
            'status' => 'required|in:publish,unpublished'
        ]);

        $post->status = $request->status;
        $post->verified_by = auth()->user()->id;

        $post->save();

        if(!$post->wasChanged()) {
            return response()->errorResponse('Could not update post', [
                "errorSource" => "Post is {$post->status}"
            ]);
        }

        return (new PostResource($post))->additional([
            'status' => 'success',
            'message' => 'Post updated successfully'
        ]);
    }

    public function destroy(Post $post) {
        if(!$post->delete()) {
            return response()->errorResponse('Failed to delete post');
        }

        return response()->success('Post deleted successfully');
    }
}
