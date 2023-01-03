<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'city';
    use HasFactory;

    public $timestamps = false; 

    protected $fillable =  [
        'city',
        'going_cost',
        'going_back_cost',
        'city_cancel_cost',
        'city_regect_cost',
        'add_date',
        'city_percent',
        'admin_id',
        'category_id',
    ];

    public function category(){
        return $this->belongsTo(Category::class,  'foreign_key', 'category_id');
    }

}
