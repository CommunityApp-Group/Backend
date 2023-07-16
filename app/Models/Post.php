<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{

    use HasFactory, Uuids, SoftDeletes;
    protected $guard = "post";

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function getRouteKeyName()
    {
        return 'id';
    }
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function postCategory() {
        return $this->belongsTo(Category::class, 'category_name', 'name');
    }

    public function setPostImageAttribute($input) {
        if($input) {
            $this->attributes['post_image'] = !is_null($input) ? uploadImage('images/post/', $input) : null;
        }
    }

    public function postcomment()
    {
        return $this->hasMany(Post_comment::class)->whereNull('parent_id');
    }


}
