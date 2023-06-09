<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Bid extends Model
{
    use HasFactory, Notifiable, SoftDeletes;
    protected $table = "bids";
    protected $guarded = ['id'];
    protected $fillable = ['price', 'user_id', 'auction_id', 'bid_time'];


    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at'
    ];
    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getBiddedTime()
    {
        return $this->created_at->format('H:i d/m/Y');
    }
}
