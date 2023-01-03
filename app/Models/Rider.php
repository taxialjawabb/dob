<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Rider extends Authenticatable implements JWTSubject {
    use HasFactory;
    protected $table = 'rider';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'password',
        'state',
        'email',
        'address',
        'email_verified_at',
        'phone',
        'phone_verified_at',
        'remember_token',
        'created_at',
        'updated_at',
    ];
    protected $hidden = [
        // 'password',
        // 'remember_token',
    ];
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function riderTrips(){
        return $this->hasMany(Trip::class);
    }
}
