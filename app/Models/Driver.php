<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Driver extends Authenticatable implements JWTSubject {
    use HasFactory;
    protected $table = 'driver';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $casts = [
        'birth_date' => 'datetime:Y-m-d',
        'driver_rate'  => "decimal:1",
        'vechile_rate'  => "decimal:1",
        'time_rate'  => "decimal:1",
        'account'  => "decimal:2",
        'id'  => "string",
        ];

    protected $dates = [
        'id_expiration_date',
        'license_expiration_date',
        'birth_date',
        'start_working_date',
        'contract_end_date',
        'final_clearance_date',
        'add_date',
        'created_at',
        'updated_at',
    ];
    protected $hidden = [
        'password',
        // 'remember_token',
    ];
    protected $fillable = [
        'name',
        'password',
        'available',
        'nationality',
        'ssd',
        'address',
        'id_copy_no',
        'id_expiration_date',
        'license_type',
        'id_type',
        'place_issue',
        'license_number',
        'license_expiration_date',
        'birth_date',
        'start_working_date',
        'contract_end_date',
        'final_clearance_date',
        'persnol_photo',
        'current_vechile',
        'add_date',
        'admin_id',
        'group_id',
        'state',
        'back',
        'email',
        'email_verified_at',
        'phone',
        'phone_verified_at',
        'remember_token',
        'created_at',
        'updated_at',
        'current_loc_latitude',
        'current_loc_longtitude',
        'current_loc_name',
        'current_loc_zipcode',
        'current_loc_id',
        'weekly_amount',
        // 'update_weekly_amount',
        'weekly_remains',
        'account',
        'on_company',
        'monthly_salary',
        'monthly_deduct',
        'insurances',
        'vacation_days',
        'vacation_days_remains',
        'group_balance',
        'driver_rate',
        'driver_counter',
        'vechile_rate',
        'vechile_counter',
        'time_rate',
        'time_counter',
    ];


    public function weekly_delay(){
        return $this->hasMany(\App\Models\Driver\DriverWeeklyDelay::class, 'driver_id', 'id');
        // return $this->hasMany(\App\Models\Driver\DriverWeeklyDelay::class, 'driver_id', 'id')->where('remains' ,'>' , 0);
    }

    public function getPersnolPhotoAttribute($value =null)
    {
        if($value !==null)
        return env("ASSET_URL")."/assets/images/drivers/personal_phonto/".$value;
    }

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

    public function driverTrips(){
        return $this->hasMany(Trip::class);
    }
    public function driverBonds(){
        return $this->hasMany(BoxDriver::class);
    }
    public function vechile(){
        return $this->hasOne(Vechile::class, 'foreign_key', 'current_vechile');
    }

    public function added_by()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'admin_id', 'id');
    }
    public function group_bill()
    {
        return $this->morphMany(\App\Models\Groups\GroupsInternalBox::class, 'foreign');
    }

}
