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
            'Category'          => $this->name,
            'Date Created'    => $this->created_at->format('Y-m-d H:i:s')
        ];
    }
}

