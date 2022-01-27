<?php

namespace App\Http\Resources\Story;

use Illuminate\Http\Resources\Json\JsonResource;

class StoryResource extends JsonResource
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
            'title'         =>  $this->title,
            'storyline'     =>  $this->storyline,
            'category'      =>  $this->category_name,
            'created_at'    =>  $this->created_at->format('Y-m-d H:i:s')
        ];
    }
}
