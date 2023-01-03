<?php

namespace App\Models\Driver;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverNotes extends Model
{
    use HasFactory;
    protected $table = 'notes_driver';
    public $timestamps = false; 
    protected $fillable = [
        'subject',
        'content',
        'note_type',
        'notes_state',
        'add_date',
        'admin_id',
        'driver_id',
        'attached',
    ];
}
