<?php

namespace App\Models;


use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory, Uuids;
    protected $guarded = [];

    protected $dates = [
        'updated_at',
        'created_at',
        'expires_at'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
