<?php

namespace App\Http\Resources\Auction;

use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
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
            'auction_id' => $this->auction_id,
            'auction_name' => $this->auction->name,
            'price' => $this->price,
            'seller' => $this->auction->user->name,
            'created_at' => $this->created_at->toDayDateTimeString(),
        ];
    }
}
