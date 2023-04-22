<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AddressCollection extends ResourceCollection
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
            'data' => $this->collection->map(function($data) {
//
//                $location_available = false;
//                $lat = 90.99;
//                $lang = 180.99;
//
//                if($data->latitude || $data->longitude) {
//                    $location_available = true;
//                    $lat = floatval($data->latitude) ;
//                    $lang = floatval($data->longitude);
//                }

                return [
                    'id'      =>(int) $data->id,
                    'user_id' =>(int) $data->user_id,
                    'name' => $data->user->firstname. " ".$data->user->lastname,
                    'address' => $data->address,
                    'state' =>  $data->state,
                    'city' =>   $data->city,
                    'phone' => $data->phone,
                    'set_default' =>(int) $data->set_default,
//                    'location_available' => $location_available,
//                    'lat' => $lat,
//                    'lang' => $lang,
                ];
            })
        ];
    }

        public function with($request)
    {
        return [
            'success' => true,
            'Message' => 'Please select shipping address',
            'status' => 200
        ];
    }
    }
