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
            'id' => $this->encodedKey,
            'email' => $this->email,
            'phone' => $this->phone,
            'username' => $this->username,
            'credit' => $this->credit,
            'gender' => $this->gender,
            'bio' => $this->bio,
            'dob' => $this->dob,
            'location' => $this->location,
            'website' => $this->website,
            'avatar' => $this->avatar,
            'cover' => $this->cover,
            'billing_address' => $this->billing_address,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'city' => $this->city,
            'country' => $this->country,
            'state' => $this->state,
            'postcode' => $this->postcode,
            'verified' => is_null($this->email_verified_at) ? 'no' : 'yes',
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'permissions' => $this->getPermissionNames()
        ];
    }

}