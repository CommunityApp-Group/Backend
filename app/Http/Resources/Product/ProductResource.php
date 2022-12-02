<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'            =>  $this->encodedKey,
            'Product'       =>  $this->product_name,
            'Description'   =>  $this->description,
            'Price'         =>  $this->product_price,
            'Image'         =>  $this->product_image,
            'category'      =>  $this->category_name,
            'created_at'    =>  $this->created_at->format('Y-m-d H:i:s')
        ];
    }
}
