<?php


namespace App\Services;



;


use App\Models\Product;
use Illuminate\Pipeline\Pipeline;
use App\Filters\ProductFilter\Category;
use App\Filters\ProductFilter\ProductName;

class ProductService
{

    public static function retrieveProduct() {
        $product_filter = app(Pipeline::class)
            ->send(Product::orderBy('created_at', 'DESC'))
            ->through([
                Category::class,
                ProductName::class
            ])
            ->thenReturn();
        return $product_filter;
    }

    public static function retrieveMyProduct() {
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