<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function auction() {
        $this->hasMany(Auction::class, 'category_name', 'name');
    }

    public function post() {
        $this->hasMany(Post::class, 'category_name', 'name');
    }

    public function product() {
        $this->hasMany(Product::class, 'category_name', 'name');
    }

    public function format() {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'created_at'    => $this->created_at
        ];
    }
}

