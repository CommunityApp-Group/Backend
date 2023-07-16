<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accommodationreview extends Model
{
    use HasFactory;
    protected $table = "accommodation_reviews";
    protected $fillable = [
        'star','customer','review'
    ];
    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }
}
