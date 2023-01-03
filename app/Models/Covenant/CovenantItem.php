<?php

namespace App\Models\Covenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CovenantItem extends Model
{
    protected $table = 'covenant_items';
    use HasFactory;

    public $timestamps = false;

    protected $fillable =  [
        'covenant_name',
        'add_by',
        'add_date',
        'serial_number',
        'current_driver',
        'state',
        'delivery_date'
    ];

    public function item_recored(){
        return $this->hasMany(Covenant\CovenantItem::class, 'covenant_name', 'covenant_name');
    }
    public function owner(){
        return $this->belongsTo(\App\Models\Driver::class, 'current_driver', 'id')->select(['id', 'name']);
    }
}
