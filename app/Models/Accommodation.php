<?php

namespace App\Models;

use App\Traits\AddUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Accommodation extends Model
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

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function accommodationCategory()
    {
        return $this->belongsTo(Category::class, 'category_name', 'name');
    }

    public function setaccommodationImageAttribute($input)
    {
        if ($input) {
            $this->attributes['accommodation_image'] = !is_null($input) ? uploadImage('images/accommodation/', $input) : null;
        }
    }
    public function reviews()
    {
        return $this->hasMany(Accommodationreview::class);
    }

}
