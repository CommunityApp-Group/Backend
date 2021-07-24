<?php

namespace App\Http\Resources\User;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $token = JWTAuth::fromUser(auth('api')->user());
        return [
            'user_info' => [
                'id' => $this->encodedKey,
                'fullname' => $this->fullname,
                'email' => $this->email,
                'call_up_no' => $this->call_up_no,
                'verified' => is_null($this->email_verified_at) ? 'no' : 'yes',
                'created_at' => $this->created_at->format('Y-m-d H:i:s'),
                'permissions' => $this->getPermissionNames()
            ]
        ];
    }
}
