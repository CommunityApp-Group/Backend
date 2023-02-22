<?php

namespace App\Http\Resources\Product;


use Illuminate\Http\Resources\Json\JsonResource;

class ProductResourceCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return
            [
            "Product" => new ProductResource($this),
            "Upload by" => [ $this-> admin->name],
            'rating' => $this->productreview->count() > 0 ? round($this->productreview->sum('star')/$this->productreview->count(),2) : 'No rating yet',

            'This Product' => ['link' => route('products.show',$this->encodedKey)],
            ];
    }
}
