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
            "Post By" => [
                'fullname' => $this->user->firstname. " ".$this->user->lastname,
                'created_at' => $this->created_at->format('Y-m-d H:i:s')
            ],
            "Comment" =>$this->postcomment
        ];
    }
}
