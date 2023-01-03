<?php

namespace App\Models\Groups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupNotes extends Model
{
    use HasFactory;
    protected $table = 'notes_group';
    public $timestamps = false;
    protected $fillable = [
        'note_type',
        'content',
        'notes_state',
        'add_date',
        'added_by',
        'group_id',
        'attached',
    ];
}
