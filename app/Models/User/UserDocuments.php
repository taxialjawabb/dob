<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDocuments extends Model
{
    use HasFactory;
    protected $table = 'documents_user';
    public $timestamps = false; 
    protected $fillable = [
        'document_type',
        'content',
        'add_date',
        'document_state',
        'admin_id',
        'user_id',
        'attached',
    ];
}
