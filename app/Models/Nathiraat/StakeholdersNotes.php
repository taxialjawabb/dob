<?php

namespace App\Models\Nathiraat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StakeholdersNotes extends Model
{
    protected $table = 'notes_nathriaat';
    public $timestamps = false; 

    use HasFactory;
    protected $fillable =  [
        'content',
        'note_type',
        'notes_state',
        'add_date',
        'admin_id',
        'nathriaat_id',
        'attached',
    ];

}
