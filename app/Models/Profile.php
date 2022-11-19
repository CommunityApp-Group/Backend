<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $dates = [
        'updated_at',
        'deleted_at'
    ];

    private $user_id;

    public function getRouteKeyName()
    {
        return 'encodedKey';
    }

//    public function user() {
//        return $this->belongsTo(User::class);
//    }


public function setProfileImageAttribute($input) {
    if($input) {
        $this->attributes['cover_image, avatar_image'] = !is_null($input) ? uploadImage('images/profile/', $input) : null;
    }
}
}