<?php

namespace App\Http\Resources\Product;

use App\Models\Admin;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

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
        return
            [
            'id'            =>  $this->id,
            'Product'       =>  $this->product_name,
            'Price'         =>  $this->product_price,
            'Image'         =>  $this->product_image,
            ];

    }
}
