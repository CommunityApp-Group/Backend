<?php

namespace App\Http\Resources\Auction;

use Illuminate\Http\Resources\Json\JsonResource;

class AuctionResource extends JsonResource
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
            'auction_name'  =>  $this->auction_name,
            'price'         =>  $this->auction_price,
            'description'   =>  $this->description,
            'category'      =>  $this->category_name,
            'status'        =>  $this->status,
//            'verified_by'   =>  optional($this->admin->verifiedBy)->email,
            'created_at'    =>  $this->created_at->format('Y-m-d H:i:s')
        ];
    }
}
