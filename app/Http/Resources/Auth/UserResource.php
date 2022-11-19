<?php

namespace App\Http\Resources\Auth;

use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $token = JWTAuth::fromUser($this->resource);

        return [
            'id' => $this->encodedKey,
            'fullname' => $this->fullname,
            'email' => $this->email,
            'call_up_no' => $this->call_up_no,
            'verified' => is_null($this->email_verified_at) ? 'no' : 'yes',
            'authentication' => respondWithToken($token),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'permissions' => $this->getPermissionNames()
        ];
    }
}
