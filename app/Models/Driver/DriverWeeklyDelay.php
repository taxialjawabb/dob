<?php

namespace App\Models\Driver;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverWeeklyDelay extends Model
{
    use HasFactory;
    protected $table = 'driver_weekly_payment_delay';
    public $timestamps = false;
    protected $fillable = [
        'weekly_money_due',
        'payed',
        'remains',
        'state',
        'added_by',
        'driver_id',
        'vechile_id',
        'start_week',
        'end_week',
    ];
}
