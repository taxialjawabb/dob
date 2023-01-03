<?php

namespace App\Models\MaintenanceCenter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVechile extends Model
{
    protected $table = 'products_vechile';
    use HasFactory;

    public $timestamps = false; 

    protected $fillable =  [
        'product_id',
        'balance_count',
        'vechile_id',
        'start_date',
        'end_date',
        'add_date',
        'add_by',
    ];
    protected $dates = [
        'start_date',
        'end_date',
        'add_date',
    ];
}
