<?php

namespace App\Models\Groups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';
    use HasFactory;

    public $timestamps = false;
    protected $dates =[
        'expired_date_commercial_register',
        'expired_date_transportation_license_number',
        'expired_date_municipal_license_number'
    ];
    protected $fillable =  [
        'name',
        'city',
        'commercial_register',
        'expired_date_commercial_register',
        'transportation_license_number',
        'expired_date_transportation_license_number',
        'municipal_license_number',
        'expired_date_municipal_license_number',
        'facility_type',
        'responsible_name',
        'phone',
        'state',
        'add_date',
        'add_by',
        'manager_id',
        'vechile_counter',
        'added_vechile',
        'added_driver',
        'group_price',
        'renew_date',
        'account',
    ];
    public function manager(){
        return $this->belongsTo(\App\Models\Admin::class, 'manager_id', 'id');
    }
    public function drivers(){
        return $this->hasMany(\App\Models\Driver::class, 'group_id')->select([ 'id', 'name', 'nationality', 'state', 'phone', 'group_id' , 'account', 'group_balance' ]);
    }
    public function vechiles(){
        return $this->hasMany(\App\Models\Vechile::class, 'group_id')->select(['id', 'vechile_type', 'made_in', 'plate_number', 'color', 'state', 'group_id', 'account', 'daily_revenue_cost', 'maintenance_revenue_cost', 'identity_revenue_cost', 'group_balance' ]);
    }
    public function users(){
        return $this->belongsToMany(\App\Models\Admin::class, 'groups_user' ,'group_id' , 'user_id')
        ->select([ 'admins.id as id', 'name', 'nationality', 'admins.state', 'phone', 'account', 'group_balance' ,'groups_user.id', 'groups_user.state']);
    }
}
