<?php

namespace App\Models;

use App\Traits\AddUUID;
use Illuminate\Pipeline\Pipeline;
use App\Filters\PostFilter\PostName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Post extends Model
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

    public function postCategory() {
        return $this->belongsTo(Category::class, 'category_name', 'name');
    }

    public function setPostImageAttribute($input) {
        if($input) {
            $this->attributes['post_image'] = !is_null($input) ? uploadImage('images/post/', $input) : null;
        }
    }

    public function comment()
    {
        return $this->hasMany(Postcomment::class);
    }

}
