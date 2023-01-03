<?php

namespace App\Models\Covenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Covenant extends Model
{
    protected $table = 'covenant';
    use HasFactory;

    public $timestamps = false;

    protected $fillable =  [
        'covenant_name',
        'add_by',
        'delivered_user',
        'add_date'
    ];

    public function items()
    {
        return $this->hasMany(CovenantItem::class, 'covenant_name', 'covenant_name');
    }
    public function added_by()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'add_by' ,'id')->select(['id', 'name']);
    }
    public function delivered_to()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'delivered_user' ,'id')->select(['id', 'name']);
    }

}
