<?php

namespace App\Models\Driver;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankTransferDriver extends Model
{
    use HasFactory;
    protected $table = 'bank_transfer_driver';
    use HasFactory;

    // public $timestamps = false; 

    protected $fillable =[
        'id',
        'state',
        'bank_name',
        'person_name',
        'money',
        'transfer_photo',
        'driver_id',
        'admin_id',
        'bond_id',
      
    ];
}
