<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccommodationCart extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id'
    ];

    public function accommodations()
    {
        return $this->hasMany(CartAccommodationDetail::class);
    }

}
