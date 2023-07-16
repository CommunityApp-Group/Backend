<?php

namespace App\Models;

use App\Models\Otp;
use App\Traits\Uuids;
use Bavix\Wallet\Traits\HasWallet;
use Bavix\Wallet\Interfaces\Wallet;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Multicaret\Acquaintances\Traits\CanLike;
use Multicaret\Acquaintances\Traits\CanFollow;
use Multicaret\Acquaintances\Traits\CanBeLiked;
use Multicaret\Acquaintances\Traits\Friendable;
use App\Notifications\ResetPasswordNotification;
use Multicaret\Acquaintances\Traits\CanBeFollowed;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable implements JWTSubject, Wallet
{
    use HasFactory, Notifiable, SoftDeletes, Uuids, HasWallet, HasRoles;
    use Friendable;
    use CanFollow, CanBeFollowed;
    use CanLike, CanBeLiked;


    protected $guard = "user";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'call_up_no', 'email',  'password', 'phone',
        'gender', 'address', 'dob', 'location', 'city', 'country', 'state', 'avatar'
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
        'id' => 'string',
    ];

    // Define relationships
    public function otp()
    {
        return $this->hasOne(Otp::class, 'user_id', 'id');
    }


    public function getRouteKeyName()
    {
        return 'id';
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

    public function auction()
    {
        return $this->hasMany(Auction::class);
    }

    public function post()
    {
        return $this->hasMany(Post::class);
    }

    public function postcomment()
    {
        return $this->hasMany(Post_comment::class);
    }

    public function productreview()
    {
        return $this->hasMany(Product_review::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }


    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function gererateOTP()
    {
        $this->resetOTP();
        $OTP = rand(1000, 9999);
        $expires = now()->addMinutes(10);
        return $this->otp()->create([
            'digit' => $OTP,
            'expires_at' => $expires
        ]);
    }

    public function resetOTP()
    {
        if ($this->otp) {
            return $this->otp->delete();
        }
    }

    public function sendPasswordResetNotification($activation_code)
    {
        $this->notify(new ResetPasswordNotification());
    }


    public function createNewToken()
    {
        return rand(100000, 999999);
    }

}