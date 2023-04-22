<?php

namespace App\Http\Resources\Accommodation;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AccommodationOrderResource extends JsonResource
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
                'href' => [
                    'Order No'       =>  $this->order_no,
                    'Description'   =>  $this->description,
                    'Accommodation'         =>  $this->accommodation_id,
                    'Status'         =>  $this->Status,
                    'note'         =>  $this->note
                ],
//                "Accommodation" => new AccommodationResource($this),
//                "User" => new UserResource($this)

            ];
        }


}
