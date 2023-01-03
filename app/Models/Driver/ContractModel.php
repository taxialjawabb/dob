<?php

namespace App\Models\Driver;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractModel extends Model
{
    protected $table = 'contract';
    public $timestamps = false; 
    use HasFactory;

}
