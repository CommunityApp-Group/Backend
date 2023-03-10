<?php

namespace App\Http\Resources\Auction;

use DB;
use Illuminate\Http\Resources\Json\JsonResource;

class BidResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $auction = DB::table('auctions')->find($this->auction_id);

        return [
            'AuctionId' => $this->auction_id,
            'Auction' => $auction->auction_name,
            'Auction price' => $auction->auction_price,
            'Auction Description' => $auction->description,
            'Bid Price' => $this->price,
            'Image'    => $auction->auction_image,
            'Bid Status'    => $this->status,
        ];
    }
}
