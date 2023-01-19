<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AdminCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "admin" => new AdminResource($this),
            'href' => [
                'link' => route('admin.show',$this->encodedKey)
            ],
            "Created By" => [
                'Name' => $this->admin->name
            ]
        ];

    }
}
