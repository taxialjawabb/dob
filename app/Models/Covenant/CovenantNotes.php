<?php

namespace App\Models\Covenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CovenantNotes extends Model
{
    
    protected $table = 'covenant_notes';
    use HasFactory;

    public $timestamps = false; 

    protected $fillable =  [
        'record_id',
        'note_state',
        'subject',
        'description',
        'add_date',
        'add_by'
    ];

}
