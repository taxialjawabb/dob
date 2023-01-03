<?php

namespace App\Models\Rating;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverRating extends Model
{
    protected $table = 'driver_rating';
    use HasFactory;

    public $timestamps = false; 

    protected $fillable =  [
        "rate_type",
        "rate",
        "content",
        "added_date",
        "rider_id",
        "driver_id"
    ];
}
