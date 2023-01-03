<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vechile extends Model
{
    use HasFactory;
    protected $table = 'vechile';
    public $timestamps = false;

    protected $dates = [
        'driving_license_expiration_date',
        'insurance_card_expiration_date',
        'periodic_examination_expiration_date',
        'operating_card_expiry_date',
        'add_date',
    ];
    protected $fillable = [
        'vechile_type',
        'made_in',
        'serial_number',
        'plate_number',
        'color',
        'registration_type',
        'operation_card_number',
        'fuel_type',
        'amount_fuel',
        'insurance_policy_number',
        'insurance_type',
        'driving_license_expiration_date',
        'insurance_card_expiration_date',
        'periodic_examination_expiration_date',
        'operating_card_expiry_date',
        'add_date',
        'state',
        'admin_id',
        'group_id',
        'category_id',
        'secondary_id',
        'account',
        'daily_revenue_cost',
        'maintenance_revenue_cost',
        'identity_revenue_cost',
    ];
    public function driver(){
        return $this->hasOne(Driver::class);
    }
    public function category(){
        return $this->belongsTo(Category::class, 'category_id','id')->select(['id','category_name']);
    }
    public function secondary_category(){
        return $this->belongsTo(SecondaryCategory::class, 'secondary_id','id')->select(['id' ,'name']);
    }
    public function added_by(){
        return $this->belongsTo(Admin::class, 'admin_id','id')->select(['id' ,'name']);
    }
    public function group_bill()
    {
        return $this->morphMony(\App\Models\Groups\GroupsInternalBox::class, 'foreign');
    }
}
