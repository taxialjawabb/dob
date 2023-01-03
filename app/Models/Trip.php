<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $table = 'trips';

    public $timestamps = false;
    protected $dates = [
        'reqest_time',
        'trip_start_time'
    ];
    protected $fillable = [
        "rider_id",
        "driver_id",
        "vechile_id",
        "state",
        "trip_type",
        "start_loc_latitude",
        "start_loc_longtitude",
        "start_loc_name",
        "start_loc_zipcode",
        "start_loc_id",
        "end_loc_latitude",
        "end_loc_longtitude",
        "end_loc_name",
        "end_loc_zipcode",
        "end_loc_id",
        "reqest_time",
        "trip_start_time",
        "trip_wait_time",
        "trip_end_time",
        "rider_rate",
        "driver_rate",
        "distance",
        "trip_time",
        "comment",
        "payment_type",
        "cost",
    ];

    protected $casts = [
        'id' => 'string',
        'cost' => 'string',
        "start_loc_latitude"=>'double',
        'start_loc_longtitude'=>'double',
        'end_loc_latitude'=>'double',
        'end_loc_longtitude'=>'double',

       ];

    public function rider(){
        return $this->belongsTo(Rider::class,  'foreign_key', 'rider_id');
    }

    public function driver(){
        return $this->belongsTo(Driver::class,  'foreign_key', 'driver_id');
    }
}
