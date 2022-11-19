<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class wallet extends Model
{
{
    // Disable auto incrementing as we set the id manually (uuid)
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'total', 'paypal_balance', 'stripe_balance',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
    ];

    protected $appends = ['pendingBalance'];

    /*
     * Relationships
     */

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /*
     * Virtual attributes
     */

    public function getPendingBalanceAttribute()
    {
        return Withdrawal::query()->where(['user_id' => Auth::user()->id, 'status' => Withdrawal::REQUESTED_STATUS])->sum('amount');
    }
}
