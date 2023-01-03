<?php

namespace App\Models\Groups\Covenants;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupsCovenantNotes extends Model
{
    use HasFactory;
    protected $table = 'groups_covenant_notes';
    public $timestamps = false;
    protected $fillable = [
        'groups_covenant_record_id',
        'note_state',
        'subject',
        'description',
        'add_date',
        'add_by',
    ];

    public function added_by()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'add_by' ,'id')->select(['id', 'name']);
    }
    public function records()
    {
        return $this->belongsTo(GroupsCovenantRecored::class, 'groups_covenant_record_id' ,'id')
        ->select(['id', 'delivery_type', 'delivery_by']);
    }
}
