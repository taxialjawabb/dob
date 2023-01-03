<?php

namespace App\Models\MaintenanceCenter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCounter extends Model
{
    protected $table = 'product_counter';
    use HasFactory;

    public $timestamps = false;

    protected $fillable =  [
        'counter_number',
        'next_counter_number',
        'product_deliverd_id',
        'added_date',
        'vechile_id',
        'driver_id',
        'admin_id',
    ];
}
