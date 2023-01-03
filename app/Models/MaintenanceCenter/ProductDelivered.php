<?php

namespace App\Models\MaintenanceCenter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDelivered extends Model
{
    protected $table = 'products_deliverd';
    use HasFactory;

    public $timestamps = false;

    protected $fillable =  [
        'product_id',
        'count',
        'driver_id',
        'vechile_id',
        'price',
        'add_date',
        'add_by',
    ];
    public function added_by(){
        return $this->belongsTo(\App\Models\Admin::class,  'add_by')->select([ 'id', 'name']);
    }
    public function driver(){
        return $this->belongsTo(\App\Models\Driver::class,  'driver_id')->select([ 'id', 'name']);
    }
    public function vechile(){
        return $this->belongsTo(\App\Models\Vechile::class,  'vechile_id')->select([ 'id', 'plate_number']);
    }
}
