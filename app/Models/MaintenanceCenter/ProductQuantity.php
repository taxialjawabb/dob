<?php

namespace App\Models\MaintenanceCenter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductQuantity extends Model
{
    protected $table = 'products_quantity';
    use HasFactory;

    public $timestamps = false; 

    protected $fillable =  [
        'product_id',
        'count',
        'type',
        'add_date',
        'add_by',
    ];
}
