<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $fillable = ['address_id',
        'user_id',
        'product_id',
        'subtotal',
        'quantity'
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at'
    ];
    public function items ()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
