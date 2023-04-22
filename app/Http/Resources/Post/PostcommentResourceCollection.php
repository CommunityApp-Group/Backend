<?php

namespace App\Http\Resources\Post;

use App\Models\Postcomment;
use Illuminate\Http\Resources\Json\JsonResource;

class PostcommentResourceCollection extends JsonResource
{

    public $collects = 'App\Http\Resources\PostResource';
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            "post" => new PostResource($this),
            "Comment" => $this->postcomment
        ];
    }
}
