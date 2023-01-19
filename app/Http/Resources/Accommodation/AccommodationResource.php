<?php

namespace App\Http\Resources\Accommodation;

use Illuminate\Http\Resources\Json\JsonResource;

class AccommodationResource extends JsonResource
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
            'id'            =>  $this->encodedKey,
            'Title'       =>  $this->title,
            'Description'   =>  $this->description,
            'Price'         =>  $this->accommodation_price,
            'Image'         =>  $this->accommodation_image,
            'category'      =>  $this->category_name,
            'Land Mark'      =>  $this->nearby,
            'State'      =>  $this->state,
            'City'      =>  $this->city,
            'LGA'      =>  $this->lga,
            'Address'      =>  $this->address,
            'accommodation Created Date'    =>  $this->created_at->format('Y-m-d H:i:s'),

        ];
    }
}
