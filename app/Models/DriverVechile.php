<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverVechile extends Model
{
    use HasFactory;
    protected $table = 'driver_vechile';
    public $timestamps = false; 
    protected $dates = [
        'start_date_drive',
        'end_date_drive',
    ];
    protected $fillable = [
        'vechile_id',
        'driver_id',
        'start_date_drive',
        'end_date_drive',
        'admin_id',
        'reason',
        ];
}
