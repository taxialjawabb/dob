<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notes extends Model
{
    
    protected $table = 'notes';
    use HasFactory;

    protected $casts = [
        'id' => 'string',
    ];
    public $timestamps = false; 

    protected $fillable =  [
        'title_ar',
        'title_en',
        'subtitle_ar',
        'subtitle_en'
    ];
}
