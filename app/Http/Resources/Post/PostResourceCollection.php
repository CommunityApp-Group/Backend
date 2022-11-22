<?php

namespace App\Http\Resources\Post;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResourceCollection extends JsonResource
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
            "post" => new PostResource($this),
            "user" => [
                'fullname' => $this->firstname. " ".$this->lastname,
                'email' => $this->user->email,
                'call_up_no' => $this->user->call_up_no,
                'created_at' => $this->created_at->format('Y-m-d H:i:s')
            ]
        ];
    }
}
