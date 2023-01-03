<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiderMessage extends Model
{
    protected $table = 'message_to_support_rider';
    use HasFactory;
    public $timestamps = false; 

    protected $fillable = [
        'rider_id',
        'send_time',
        'subject',
        'content',
        'message_state',
    ];
}
