<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    use HasFactory;

    public $timestamps = false; 

    protected $fillable =  [
        'id',
        'category_name',
        'basic_price',
        'km_cost',
        'minute_cost',
        'reject_cost',
        'cancel_cost',
        'percentage_type',
        'daily_revenue_cost',
        'fixed_percentage',
        'category_percent',
        'admin_id',
        'show_in_app',
        'rate',
        'rate_counter',
    ];
    public function cities(){
        return $this->hasMany(City::class);
    }

    public function secondary(){
        return $this->hasMany(SecondaryCategory::class);
    }
}
