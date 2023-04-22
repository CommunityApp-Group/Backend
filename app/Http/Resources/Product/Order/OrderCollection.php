<?php

namespace App\Http\Resources\Product\Order;

use DB;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderCollection extends ResourceCollection
{
    public $collects = 'App\Http\Resources\OrderResource';
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = DB::table('users')->find($this->user_id);
        return [
            'Orders' => $this->collection,
            'orders_count' => $this->collection->count(),
             "Owner Details" => ['Name' => $user->firstname. " ".$user->lastname,
        'E-mail' => $user->email,
        'Phone' => $user->phone],
        ];
    }
}
