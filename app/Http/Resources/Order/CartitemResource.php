<?php

namespace App\Http\Resources\Order;

use App\Models\Product;
use DB;
use Illuminate\Http\Resources\Json\JsonResource;

class CartitemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $product = DB::table('products')->find($this->product_id);

        return [
            'productID' => $this->product_id,
            'price' => $product->product_price,
            'Name' => $product->product_name,
            'Quantity' => $this->quantity,
            'Image'    => $product->product_image,
            'Subtotal'    => $this->subtotal,
        ];
    }
}
