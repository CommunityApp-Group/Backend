<?php

namespace App\Http\Controllers\Api\Story;

use App\Http\Controllers\Controller;
use App\Http\Requests\Story\CreateStoryRequest;
use App\Models\Story;
use App\Services\StoryService;
use App\Traits\GetRequestType;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Resources\Story\StoryResource;




class StoryController extends Controller
{
    use GetRequestType;

    public function __construct()
    {
        $this->middleware('auth.jwt')->except(['index']);
    }

    public function index() {
        $stories = StoryService::retrieveStory();
        return $this->getFullStory($stories)->additional([
            'message' => 'Story successfully retrieved',
            'status' => 'success'
        ]);
    }

    public function store(CreateStoryRequest $request) {
        try {
            if(!$story = $request->createStory()) {
                return response()->errorResponse('Failed to create story! Please try again later');
            }

            return (new StoryResource($story))->additional([
                'message' => 'Story successfully created',
                'status' => 'success'
            ]);
        } catch(QueryException $e) {
            report($e);
            return response()->errorResponse('Failed to create story! Please try again later');
        }
    }

    public function show(Story $story) {

        return $this->getSimpleStory($story)->additional([
            'message' => 'Story successfully retrieved',
            'status' => 'success'
        ]);
    }
    public function storylist(Story $story) {
        $storys = StoryService::retrieveMyStory();
        return $this->getMystory($story)->additional([
            'message' => 'My Auction successfully retrieved',
            'status' => 'success'
        ]);
    }

    public function update(CreateStoryRequest $request, Story $story) {
        $user = auth()->user();
        if($story->user_id !== $user->id) return response()->errorResponse('Permission Denied', [], 403);

        if(!$update_story = $story->update(
            $request->validated()
        )) {
            return response()->errorResponse('Story Update Failed');
        }

        return (new StoryResource($story))->additional([
            'message' => 'Story successfully updated',
            'status' => 'success'
        ]);
    }

    public function destroy(Story $story) {
        $user = auth()->user();
        if($story->user_id !== $user->id) return response()->errorResponse('Permission Denied', [], 403);

        if(!$story->delete()) {
            return response()->errorResponse('Failed to delete story');
        }

        return response()->success('Story deleted successfully');
    }
}
