<?php

namespace App\Models;

use App\Traits\AddUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
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

    public function user()
    {
        return $this->belongsTo(User::class);
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

}
