<?php

namespace App\Models\Groups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupVechilePrice extends Model
{
    protected $table = 'group_vechile_price';
    use HasFactory;

    // public $timestamps = false; 

    protected $fillable =  [
        'id',
        'vechile_price',
        'admin_id',
    ];
}
