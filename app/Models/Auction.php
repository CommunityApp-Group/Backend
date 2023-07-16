<?php

namespace App\Models;

use App\Traits\AddUUID;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Database\Eloquent\Model;
use App\Filters\AuctionFilter\AuctionName;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Auction extends Model
{
    use HasFactory,  SoftDeletes;

    protected $table = "auctions";

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'end_time'
    ];

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(Admin::class, 'verified_by');
    }

    public function auctionCategory()
    {
        return $this->belongsTo(Category::class, 'category_name', 'name');
    }

    public function setAuctionImageAttribute($input)
    {
        if ($input) {
            $this->attributes['auction_image'] = !is_null($input) ? uploadImage('images/auction/', $input) : null;
        }
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }


    /**
     * Get Auction status.
     *
     * @param string $value
     * @return string
     */
    public function getStatusAttribute($value)
    {
        if ($value === 'sale') return 'On sale';
        if ($value === 'sold') return 'Sold';
        return 'Draft';
    }

    /**
     * Get Auction sale timestamp.
     *
     * @return int
     */
    public function getSaleTimestampAttribute()
    {
        return Carbon::create($this->end_time)->timestamp;
    }

    /**
     * Get the starting price of the Auction  or the maximum bid value.
     *
     * @param int $value
     * @return mixed
     */
    public function getStartPriceAttribute($value)
    {
        return $this->bids->isNotEmpty() ? $this->bids->max('price') : $value;
    }

    /**
     * Get the number of unique bids for the Auction .
     *
     * @return int
     */
    public function getNumberOfUniqueBidsAttribute()
    {
        return $this->bids->groupBy('user_id')->count();
    }

    /**
     * Deleting a folder with images after deleting a lot.
     */
    protected static function booted()
    {
        static::deleted(function ($auction) {
            $auction->images()->delete();
            Storage::disk('local')->deleteDirectory('public/images/auction/' . $auction->id);
        });
    }
}
