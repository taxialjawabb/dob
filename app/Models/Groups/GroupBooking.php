<?php

namespace App\Models\Groups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupBooking extends Model
{
    protected $table = 'groups_booking';
    use HasFactory;

    // public $timestamps = false; 

    protected $fillable =  [
        'added_by',
        'group_id',
        'vechile_counter',
        'booking_price',
        'start_date',
        'end_date',
    ];
}
