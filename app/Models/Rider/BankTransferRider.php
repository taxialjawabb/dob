<?php

namespace App\Models\Rider;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankTransferRider extends Model
{
    use HasFactory;
    protected $table = 'bank_transfer_rider';
    use HasFactory;

    // public $timestamps = false; 

    protected $fillable =[
        'id',
        'state',
        'bank_name',
        'person_name',
        'money',
        'transfer_photo',
        'rider_id',
        'admin_id',
        'bond_id',
      
    ];
}
