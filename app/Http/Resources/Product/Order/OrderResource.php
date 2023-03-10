<?php

namespace App\Http\Resources\Product\Order;

use App\Models\OrderItem;
use DB;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'Order No' => $this->order_no,
            'Total Price' => $this->total,
            'Status' => $this->status,
            'Date' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
