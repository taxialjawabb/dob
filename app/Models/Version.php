<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    protected $table = 'version';
    use HasFactory;

    public $timestamps = false; 

    protected $fillable =  [
        'driver',
        'rider'
    ];
}
