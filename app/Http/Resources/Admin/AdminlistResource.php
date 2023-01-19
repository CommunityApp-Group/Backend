<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminlistResource extends JsonResource
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
            'id' => $this->encodedKey,
            'Name' => $this->   name,
            'Phone'         =>  $this->phone,
            'Location'      =>  $this->location,
            'Email'         =>  $this->email,
            'status'         =>  $this->status,
            'created_at'    =>  $this->created_at->format('Y-m-d H:i:s'),
            'Created_by'    =>  $this->created_by,
             'href' => [
        'link' => route('admin.admin.show',$this->encodedKey)
    ],
        ];
    }
}
