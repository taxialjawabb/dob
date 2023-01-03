<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class banner extends Model
{
    use HasFactory;
    protected $table = 'banners';
   

    public $timestamps = false; 
    protected $casts = [
        'id' => 'string',
    ];
    protected $fillable =  [
     
        'title',
        'image',
    ];

    public function getImageAttribute($value =null)
    {
        if($value !==null)
        return "http://192.168.0.122/jwab/public/assets/images/drivers/personal_phonto/".$value;
    }
}
