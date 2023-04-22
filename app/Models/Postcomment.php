<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postcomment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post'
    ];

    /**
     * The belongs to Relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @var array
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The has Many Relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * The has Many Relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Postcomment::class, 'parent_id');
    }
}
