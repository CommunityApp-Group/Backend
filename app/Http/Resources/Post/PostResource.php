<?php

namespace App\Http\Resources\Post;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'id'            =>  $this->encodedKey,
            'Post'          =>  $this->postline,
            'Image'         =>  $this->post_image,
            'category'      =>  $this->category_name,
            'created_at'    =>  $this->created_at->format('Y-m-d H:i:s')
        ];
    }
}
