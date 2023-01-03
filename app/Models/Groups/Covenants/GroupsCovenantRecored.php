<?php

namespace App\Models\Groups\Covenants;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupsCovenantRecored extends Model
{
    use HasFactory;
    protected $table = 'groups_covenant_record';
    public $timestamps = false;
    protected $fillable = [
        'added_by',
        'delivery_date',
        'delivery_type',
        'delivery_by',
        'receive_date',
        'receive_type',
        'receive_by',
        'groups_covenant_id',
    ];

    public function delivered_driver()
    {
        return $this->belongsTo(\App\Models\Driver::class, 'delivery_by', 'id')->select(['id', 'name']);
    }
    public function delivered_user()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'delivery_by', 'id')->select(['id', 'name']);
    }
    public function receive_driver()
    {
        return $this->belongsTo(\App\Models\Driver::class, 'receive_by', 'id')->select(['id', 'name']);
    }
    public function receive_user()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'receive_by', 'id')->select(['id', 'name']);
    }
}
