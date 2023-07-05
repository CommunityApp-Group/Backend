<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserlistResource extends JsonResource
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
            'id' => $this->id,
            'fullname' => $this->firstname. " ".$this->lastname,
            'email' => $this->email,
            'call_up_no' => $this->call_up_no,
            'phone' => $this->phone,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'href' => [
                'link' => route('users.profile.show',$this->id)
            ],
        ];
    }
}
