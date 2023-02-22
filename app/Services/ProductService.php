<?php
namespace App\Services;

use App\Models\Product;
use Illuminate\Pipeline\Pipeline;
use App\Filters\ProductFilter\Category;
use App\Filters\ProductFilter\ProductName;

class ProductService
{
    public static function retrieveMyProduct() {
        $product_filter = app(Pipeline::class)
            ->send(Product::where('admin_id',  auth()->guard('admin')->id()))
            ->through([
                Category::class,
                ProductName::class
            ])
            ->thenReturn();
        return $product_filter;
    }

    public static function retrievePopularProduct() {
        $product_filter = app(Pipeline::class)
            ->send(Product::where('user_id',  auth()->id()))
            ->through([
                Category::class,
                ProductName::class
            ])
            ->thenReturn();
        return $product_filter;
    }
}