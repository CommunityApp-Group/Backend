<?php

namespace App\Http\Resources\Friend;

use Illuminate\Http\Resources\Json\JsonResource;


class FriendsResource extends JsonResource
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
            'fullname' => $this->user->firstname,

    ];
    }
}
