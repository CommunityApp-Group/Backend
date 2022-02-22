<?php

namespace App\Services;

use App\Models\Story;
use Illuminate\Pipeline\Pipeline;
use App\Filters\StoryFilter\StoryName;
use App\Filters\StoryFilter\Category;

class StoryService {
    public static function retrieveStory() {
        $story_filter = app(Pipeline::class)
            ->send(Story::orderBy('created_at', 'DESC'))
            ->through([
                Category::class,
                StoryName::class
            ])
            ->thenReturn();
        return $story_filter;
    }

    public static function retrieveMyStory() {
        $story_filter = app(Pipeline::class)
            ->send(Story::where('user_id',  auth()->id()))
            ->through([
                Category::class,
                StoryName::class
            ])
            ->thenReturn();
        return $story_filter;
    }
}
