<?php

namespace App\Models;

use App\Traits\AddUUID;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Database\Eloquent\Model;
use App\Filters\AuctionFilter\AuctionName;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Auction extends Model
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

    public function verifiedBy() {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function auctionCategory() {
        return $this->belongsTo(Category::class, 'category_name', 'name');
    }

    public function setAuctionImageAttribute($input) { 
        if($input) {
            $this->attributes['auction_image'] = !is_null($input) ? uploadImage('images/auction/', $input) : null;
        }
     }
}
