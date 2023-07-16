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
            'id'            =>  $this->id,
            'Title'       =>  $this->title,
            'Description'   =>  $this->description,
            'Price'         =>  $this->accommodation_price,
            'Image'         =>  $this->accommodation_image,
            'category'      =>  $this->category_name,
            'Land Mark'      =>  $this->nearby,
            'Bathroom'      =>  $this->bathroom,
            'Bedroom'      =>  $this->bedroom,
            'Type'      =>  $this->type,
            'State'      =>  $this->state,
            'City'      =>  $this->city,
            'LGA'      =>  $this->lga,
            'Address'      =>  $this->address,
            'accommodation Created Date'    =>  $this->created_at->format('Y-m-d H:i:s'),
            'rating' => $this->reviews->count() > 0 ? round($this->reviews->sum('star')/$this->reviews->count(),2) : 'No rating yet',
            'href' => [
                'reviews' => route('reviews.index',$this->id)
            ],
            "Uploaded By" => [
                'Name' => $this-> admin->name
            ]
        ];

    }
}
