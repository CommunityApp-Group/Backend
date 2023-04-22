<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "addresses";
    protected $fillable = [
      'phone', 'address', 'city','state','set_default'
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
