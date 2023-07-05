<?php

namespace App\Http\Resources\Admin;

use DB;
use Illuminate\Http\Resources\Json\JsonResource;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;


class AdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $token = JWTAuth::fromUser($this->resource);
        $admin = DB::table('admins')->find($this->created_by);
        return [
            'id'            => $this->id,
            'Name'          => $this->name,
            'Phone'         =>  $this->phone,
            'Location'      =>  $this->location,
            'Email'         =>  $this->email,
            'status'        =>  $this->status,
            'created_at'    =>  $this->created_at->format('Y-m-d H:i:s'),
            'Created_by'    => $admin->name,
            'authentication' => respondWithToken($token)
        ];
    }
}
