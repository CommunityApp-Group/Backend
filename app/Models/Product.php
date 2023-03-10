<?php

namespace App\Models;

use App\Traits\AddUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, AddUUID, SoftDeletes;

    protected $table = "product";
    protected $guarded = ["id"];

    public function orders()
    {
        return $this->belongsToMany("Order", "order_item");
    }

    public function orderItems()
    {
        return $this->hasMany("OrderItem");
    }


    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function getRouteKeyName()
    {
        return 'encodedKey';
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }


    public function productCategory()
    {
        return $this->belongsTo(Category::class, 'category_name', 'name');
    }

    public function setProductImageAttribute($input)
    {
        if ($input) {
            $this->attributes['product_image'] = !is_null($input) ? uploadImage('images/product/', $input) : null;
        }
    }
    public function productreview()
    {
        return $this->hasMany(Productreview::class);
    }

}
