<?php

namespace App\Http\Resources\User;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResourceCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->encodedKey,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'verified' => is_null($this->email_verified_at) ? 'no' : 'yes',
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'permissions' => $this->getPermissionNames()
        ];
    }

}
