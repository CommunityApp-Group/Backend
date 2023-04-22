<?php

namespace App\Http\Resources\Accommodation;

use Illuminate\Http\Resources\Json\JsonResource;

class AccommodationsResourceCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "Accommodation" => new AccommodationResource($this),
            'href' => [
                'link' => route('accommodation.show',$this->encodedKey)
            ],
        ];
    }
}
