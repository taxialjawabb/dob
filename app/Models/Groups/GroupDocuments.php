<?php

namespace App\Models\Groups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupDocuments extends Model
{
    use HasFactory;
    protected $table = 'documents_group';
    public $timestamps = false;
    protected $fillable = [
        'document_type',
        'content',
        'add_date',
        'document_state',
        'added_by',
        'group_id',
        'attached',
    ];

    public function group()
    {
        return $this->belongsTo(\App\Models\Groups\Group::class, 'group_id', 'id');
    }
}
