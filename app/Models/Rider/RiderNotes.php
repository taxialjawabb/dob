<?php

namespace App\Models\Rider;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiderNotes extends Model
{
    use HasFactory;
    protected $table = 'notes_rider';
    public $timestamps = false; 
    protected $fillable = [
        'subject',
        'content',
        'note_type',
        'notes_state',
        'add_date',
        'admin_id',
        'rider_id',
        'attached',
    ];
}
