<?php

namespace App\Models\Driver;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverEmployeeMonthlySalary extends Model
{
    protected $table = 'employees_driver_monthly_salary';

    protected $fillable = [
        'total_salary',
        'basic_salary',
        'deduction',
        'insurances',
        'vacation_days',
        'absence_days',
        'delay_days_hours',
        'delay_hours',
        'final_salary',
        'note',
        'driver_id',
        'confirmed_date',
        'confirmed_by',
    ];
    public function user_data(){
        return $this->belongsTo(\App\Models\Driver::class,  'driver_id')->select([ 'id', 'name']);
    }
    public function confirmed(){
        return $this->belongsTo(\App\Models\Admin::class,  'confirmed_by')->select([ 'id', 'name']);
    }

}
