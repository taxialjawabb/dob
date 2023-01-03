<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotes extends Model
{
    use HasFactory;
    protected $table = 'notes_user';
    public $timestamps = false; 
    protected $fillable = [
        'subject',
        'content',
        'note_type',
        'notes_state',
        'add_date',
        'admin_id',
        'user_id',
        'attached',
    ];
}
