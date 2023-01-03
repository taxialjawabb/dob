<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingDiscount extends Model
{
    protected $table = 'booking_discount';
    use HasFactory;

    public $timestamps = false; 

    protected $fillable =  [
        'percentage_from',
        'percentage_to',
        'percentage',
    ];
}
