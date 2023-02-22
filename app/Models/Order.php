<?php

namespace App\Models;


use App\Traits\OrderNo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, OrderNo,  SoftDeletes;
    protected $table = "orders";
    protected $guarded = ["id"];

    public function getRouteKeyName()
    {
        return 'order_no';
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItem()
    {
        return $this->hasMany(OrderItem::class);

    }

    public function products()
    {
        return $this->belongsToMany(Product::class, "orderItem");
    }


    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
