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
            'Product Created Date'    =>  $this->created_at->format('Y-m-d H:i:s'),
            'rating' => $this->reviews->count() > 0 ? round($this->reviews->sum('star')/$this->reviews->count(),2) : 'No rating yet',
            'href' => [
                'reviews' => route('reviews.index',$this->encodedKey)
            ],
            "user" => [
                'Full Name' => $this->user->firstname. " ".$this->user->lastname
            ]
                 ];
    }
}
