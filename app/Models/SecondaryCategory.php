<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecondaryCategory extends Model
{
    protected $table = 'secondary_category';
    use HasFactory;

    public $timestamps = false; 

    protected $fillable =  [
        'name',
        'percentage_type',
        'fixed_percentage',
        'category_percent',
        'admin_id',
        'category_id'
    ];
    public function category(){
        return $this->belongsTo(Category::class,  'foreign_key', 'category_id');
    }
}
