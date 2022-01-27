<?php

namespace App\Models;

use App\Traits\AddUUID;
use Illuminate\Pipeline\Pipeline;
use App\Filters\StoryFilter\StoryName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Story extends Model
{
    use HasFactory, AddUUID, SoftDeletes;

    protected $guarded = ['id'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function getRouteKeyName()
    {
        return 'encodedKey';
    }
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function storyCategory() {
        return $this->belongsTo(Category::class, 'category_name', 'name');
    }

    public function setStoryImageAttribute($input) {
        if($input) {
            $this->attributes['story_image'] = !is_null($input) ? uploadImage('images/story/', $input) : null;
        }
    }
}
