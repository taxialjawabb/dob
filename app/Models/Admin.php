<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;
class Admin extends Authenticatable implements JWTSubject {
    use LaratrustUserTrait;
    use HasFactory;
    protected $table = 'admins';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'password',
        'nationality',
        'ssd',
        'date_join',
        'Employment_contract_expiration_date',
        'final_clearance_exity_date',
        'id_expiration_date',
        'working_hours',
        'monthly_salary',
        'roles',
        'state',
        'add_by',
        'email',
        'email_verified_at',
        'phone',
        'phone_verified_at',
        'remember_token',
        'created_at',
        'updated_at        ',
    ];
    protected $dates = [
        'date_join',
        'Employment_contract_expiration_date',
        'final_clearance_exity_date',
        'created_at',
        'updated_at        ',

    ];
    protected $hidden = [
        'password',
        'remember_token',
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

    public function confirmBoxAdmin(){
        return $this->hasMany(\App\Models\User\BoxUser::class,  'confirm_by', 'id');
    }
    public function confirmBoxDriver(){
        return $this->hasMany(\App\Models\Driver\BoxDriver::class, 'confirm_by', 'id');
    }
    public function confirmBoxVechile(){
        return $this->hasMany(\App\Models\Vechile\BoxVechile::class, 'confirm_by', 'id');
    }
    public function confirmBoxRider(){
        return $this->hasMany(\App\Models\Rider\BoxRider::class, 'confirm_by', 'id');
    }
    public function confirmBoxNathiraat(){
        return $this->hasMany(\App\Models\Nathiraat\BoxNathriaat::class, 'confirm_by', 'id');
    }
    public function truthworthBoxAdmin(){
        return $this->hasMany(\App\Models\User\BoxUser::class,  'trustworthy_by', 'id');
    }
    public function truthworthBoxDriver(){
        return $this->hasMany(\App\Models\Driver\BoxDriver::class, 'trustworthy_by', 'id');
    }
    public function truthworthBoxVechile(){
        return $this->hasMany(\App\Models\Vechile\BoxVechile::class, 'trustworthy_by', 'id');
    }
    public function truthworthBoxRider(){
        return $this->hasMany(\App\Models\Rider\BoxRider::class, 'trustworthy_by', 'id');
    }
    public function truthworthBoxNathiraat(){
        return $this->hasMany(\App\Models\Nathiraat\BoxNathriaat::class, 'trustworthy_by', 'id');
    }
    public function depositBoxAdmin(){
        return $this->hasMany(\App\Models\User\BoxUser::class,  'deposited_by', 'id');
    }
    public function depositBoxDriver(){
        return $this->hasMany(\App\Models\Driver\BoxDriver::class, 'deposited_by', 'id');
    }
    public function depositBoxVechile(){
        return $this->hasMany(\App\Models\Vechile\BoxVechile::class, 'deposited_by', 'id');
    }
    public function depositBoxRider(){
        return $this->hasMany(\App\Models\Rider\BoxRider::class, 'deposited_by', 'id');
    }
    public function depositBoxNathiraat(){
        return $this->hasMany(\App\Models\Nathiraat\BoxNathriaat::class, 'deposited_by', 'id');
    }
    public function groups(){
        return $this->belongsToMany(\App\Models\Groups\Group::class, 'groups_user'  , 'user_id','group_id');
    }

    public function group_bill()
    {
        return $this->morphMony(\App\Models\Groups\GroupsInternalBox::class, 'foreign');
    }
}
