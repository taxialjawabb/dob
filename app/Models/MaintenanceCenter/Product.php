<?php

namespace App\Models\MaintenanceCenter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    use HasFactory;

    public $timestamps = false; 

    protected $fillable =  [
        'name',
        'total',
        'stored',
        'used',
        'returned',
        'free_count',
        'periodic_days',
        'price',
        'add_date',
        'add_by',
    ];
}
