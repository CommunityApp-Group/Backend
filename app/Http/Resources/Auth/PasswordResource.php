<?php

namespace App\Http\Resources\Auth;

use App\Models\Otp;
use DB;
use Illuminate\Http\Resources\Json\JsonResource;

class PasswordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    { $users = DB::table('users')
        ->join('otps', 'otps.user_id', '=', 'users.id')
        ->where('otps.digit', '=',$request->token)
        ->select('users.id')
        ->get();

        return [
            'id' => $this->$users,
            'href' => [
                'link' => route('users.show',$token)
            ],
//
        ];
    }
}
