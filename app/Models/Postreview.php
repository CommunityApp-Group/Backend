<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postreview extends Model
{
    use HasFactory;

    protected $fillable = [
        'star','customer','review'
    ];
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
