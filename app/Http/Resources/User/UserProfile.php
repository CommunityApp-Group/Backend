<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProfile extends JsonResource
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
            'id' => $this->id,
            'Email' => $this->email,
            'Phone' => $this->phone,
            'Gender' => $this->gender,
            'Date of Birth' => $this->dob,
            'location' => $this->location,
            'avatar' => $this->avatar,
            'Address' => $this->address,
            'First Name' => $this->firstname,
            'Last Name' => $this->lastname,
            'city' => $this->city,
            'country' => $this->country,
            'state' => $this->state,
            'post' => $this->post->count() > 0 ? round($this->post->count(),2) : 'No post yet',
           // 'friends' => $this->friendship->count() > 0 ? round($this->friendship->count(),2) : 'No Friends yet',


        ];
    }

}