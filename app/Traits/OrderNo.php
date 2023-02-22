<?php

namespace App\Traits;

use Haruncpi\LaravelIdGenerator\IdGenerator;

trait OrderNo
{

    /**
     * Boot function from Laravel.
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $user_id = auth()->user()->id;
            $date = date("ymdis");
            if (empty($model->order_no)) {
                $model->order_no  = $user_id .$date  ;
            }
        });
    }
}
