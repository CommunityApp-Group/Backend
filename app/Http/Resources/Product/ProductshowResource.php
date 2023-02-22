<?php

namespace App\Http\Resources\Product;

use App\Models\Admin;
use App\Models\Productreview;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class ProductshowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return
            [
            'id'            =>  $this->encodedKey,
            'Product'       =>  $this->product_name,
            'Description'   =>  $this->description,
            'Price'         =>  $this->product_price,
            'Image'         =>  $this->product_image,
            'Category'      =>  $this->category_name,
            'Product Updated at' => Carbon::parse($this->updated_at)->format('Y-m-d'),
            'Product Created at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            "Upload by" => [ $this-> admin->name],

            'Rating' => $this->productreview->count() > 0 ? round($this->productreview->sum('star')/$this->productreview->count(),2) : 'No rating yet',
            'Total Reviews' => $this->productreview->count() ,
            'Product Reviews' => [route('productreviews.index',$this->encodedKey)],
            ];
    }
}
