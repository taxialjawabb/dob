<?php

namespace App\Models\Groups\Covenants;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupsCovenant extends Model
{
    use HasFactory;
    protected $table = 'groups_covenant';
    public $timestamps = false;
    protected $fillable = [
        'covenant_name',
        'serial_number',
        'add_date',
        'added_by',
        'state',
        'delivery_date',
        'driver_id',
        'group_id',
    ];
    public function addedby()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'added_by' ,'id')->select(['id', 'name']);
    }
    public function deliveredTo()
    {
        return $this->belongsTo(\App\Models\Driver::class, 'driver_id', 'id')->select(['id', 'name']);
    }
}
