<?php

namespace App\Services;

use App\Models\Story;
use Illuminate\Pipeline\Pipeline;
use App\Filters\StoryFilter\StoryName;
use App\Filters\StoryFilter\Category;

class StoryService {
    public static function retrieveStory() {
        $story_filter = app(Pipeline::class)
            ->send(Story::where('storyline', 'storyline'))
            ->through([
                Category::class,
                StoryName::class
            ])
            ->thenReturn();
        return $story_filter;
    }
}
