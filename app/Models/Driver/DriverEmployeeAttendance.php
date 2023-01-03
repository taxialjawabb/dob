<?php

namespace App\Models\Driver;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverEmployeeAttendance extends Model
{
    protected $table = 'employees_driver_attendance';

    public $timestamps = false;
    protected $dates = [
        'date_is',
        'add_date',
    ];
    protected $fillable = [
        'date_is',
        'reason',
        'absence_type',
        'add_date',
        'added_by',
        'driver_id',
        'delay_hours',
    ];
    public function admin_data(){
        return $this->belongsTo(\App\Models\Admin::class,  'added_by')->select([ 'id', 'name']);
    }
}
