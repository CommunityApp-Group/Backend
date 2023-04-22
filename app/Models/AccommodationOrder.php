<?php

namespace App\Models;

use App\Traits\OrderNo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccommodationOrder extends Model
{
    use HasFactory, OrderNo, SoftDeletes;
    protected $table = "accommodation_orders";
    protected $guarded = ["id"];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $fillable = [
        'user_id', 'order_number', 'name', 'address', 'accommodation_id' , 'notes'
    ];
    public function getRouteKeyName()
    {
        return 'order_no';
    }
//    public function user()
//    {
//        return $this->belongsTo(User::class);
//    }

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }
}
