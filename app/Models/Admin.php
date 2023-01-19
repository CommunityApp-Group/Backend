<?php

namespace App\Models;


use App\Traits\AddUUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends  Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, SoftDeletes, AddUUID, HasRoles;

    protected $guard = "admin";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'status',
        'email',
        'encodedKey',
        'phone',
        'location'
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at'
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
    public function product() {
        return $this->hasMany(Product::class);
    }

    public function sendPasswordResetNotification($token) {
        $this->notify(new ResetPasswordNotification($token));
    }
    public function verifiedAuction() {
        return $this->hasMany(Auction::class, 'verified_by');
    }

    public function createdby() {
        return $this->hasMany(Admin::class, 'created_by');
    }

    public function admin() {
        return $this->hasMany(Admin::class);
    }
    public function accommodation() {
        return $this->hasMany(Accommodation::class);
    }
}
