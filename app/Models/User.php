<?php

namespace App\Models;

use App\Models\Otp;
use App\Traits\AddUUID;
use Bavix\Wallet\Traits\HasWallet;
use Bavix\Wallet\Interfaces\Wallet;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Bavix\Wallet\Traits\HasWalletFloat;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Bavix\Wallet\Interfaces\WalletFloat;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject, Wallet, WalletFloat
{
    use HasFactory, Notifiable, SoftDeletes, AddUUID, HasWallet, HasWalletFloat, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fullname',
        'call_up_no',
        'email',
        'encodedKey',
        'password',
        'gender'
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Define relationships
    public function otp() {
        return $this->hasOne(Otp::class, 'parentEncodedKey', 'encodedKey');
    }


    public function getRouteKeyName()
    {
        return 'encodedKey';
    }

    // Define JWT auth methods
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Relationships
    */

    public function auction() {
        return $this->hasMany(Auction::class);
    }

    public function story() {
        return $this->hasMany(Story::class);
    }

    public function verifiedAuction() {
        return $this->hasMany(Auction::class, 'verified_by');
    }

    public function setPasswordAttribute($input) {
        if($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function gererateOTP() {
        $this->resetOTP();
        $OTP = rand(10000, 99999);
        $expires = now()->addMinutes(10);
        return $this->otp()->create([
            'digit' => $OTP,
            'expires_at' => $expires
        ]);
    }
    public function resetOTP() {
        if($this->otp) {
            return $this->otp->delete();
        }
    }

    public function sendPasswordResetNotification($token) {
        $this->notify(new ResetPasswordNotification($token));
    }


    public function createNewToken() {
        return rand(100000, 999999);
    }
}
