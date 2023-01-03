<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralBox extends Model
{
    protected $table = 'general_box';
    use HasFactory;

    public $timestamps = false; 

    protected $fillable =  [
        'account',
        'take',
        'spend',
        'updated_at'
    ];

}
