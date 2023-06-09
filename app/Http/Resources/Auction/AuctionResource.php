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
            'image'         =>  $this->auction_image,
            'price'         =>  $this->auction_price,
            'description'   =>  $this->description,
            'location'      =>  $this->location,
            'category'      =>  $this->category_name,
            'status'        =>  $this->status,
            'Verification'  =>  $this->verification,
            'End date'      =>  $this->end_time->toDayDateTimeString(),
            'bid_step'      =>  $this->step,
            'verified_by'   =>  optional($this->verifiedBy)->name,
    //        'created_at'    =>  $this->created_at->format('Y-m-d H:i:s')
            'created_at'    => $this->created_at->toDayDateTimeString(),
        ];
    }
}
