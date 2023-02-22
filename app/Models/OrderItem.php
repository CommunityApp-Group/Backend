<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = "order_items";
    protected $guarded = ["id"];

    public function product()
    {
        return $this->belongsTo("Product");
    }

    public function order()
    {
        return $this->belongsTo("Order");
    }
    public function cart()
    {
        return $this->belongsTo("Cart");
    }


    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
