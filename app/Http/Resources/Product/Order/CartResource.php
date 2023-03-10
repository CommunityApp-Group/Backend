<?php

namespace App\Http\Resources\Product\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'price' => $this->product_price,
            'Name' => $this->product_name,
            'Quantity' => $this->quantity,
            'Image'    => $this->product_image,
        ];
    }
}
