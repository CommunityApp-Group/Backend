<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartAccommodationDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id', 'accommodation_id', 'quantity'
    ];

    public function accommodationCart()
    {
        return $this->belongsTo(AccommodationCart::class);
    }

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }
}
