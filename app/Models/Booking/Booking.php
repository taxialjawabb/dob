<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    
    protected $table = 'booking';
    use HasFactory;


    protected $fillable =  [
        'state',
        'price',
        'start_date',
        'end_date',
        'start_loc_latitude',
        'start_loc_longtitude',
        'start_loc_name',
        'end_loc_latitude',
        'end_loc_longtitude',
        'end_loc_name',
        'distance',
        'trip_time',
        'has_return',
        'going_time',
        'back_time',
        'list_date',
        'rider_id',
        'driver_id',
        'category_id'
    ];

    public function rider(){
        return $this->belongsTo(\App\Models\Rider::class, 'rider_id');
    }
    public function driver(){
        return $this->belongsTo(\App\Models\Driver::class, 'driver_id');
    }
}
