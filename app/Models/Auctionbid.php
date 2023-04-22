<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Auctionbid extends Model
{
    use HasFactory, Notifiable, SoftDeletes;
    protected $table = "auctionbids";
    protected $guarded = ['id'];

    protected $fillable = [
        'user_id',
        'auction_id',
        'price',
        'quantity'
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at'
    ];
}
