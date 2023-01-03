<?php

namespace App\Models\Vechile;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VechileNotes extends Model
{
    use HasFactory;
    protected $table = 'notes_vechile';
    public $timestamps = false; 
    protected $fillable = [
        'subject',
        'content',
        'note_type',
        'notes_state',
        'add_date',
        'admin_id',
        'vechile_id',
        'attached',
    ];
}
