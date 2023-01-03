<?php

namespace App\Models\Groups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupImportExport extends Model
{
    use HasFactory;
    protected $table = 'groups_import_export';
    public $timestamps = false;
    protected $fillable = [
        'stackholder',
        'title',
        'content',
        'type',
        'add_date',
        'added_by',
        'group_id',
        'attached',
    ];
}
