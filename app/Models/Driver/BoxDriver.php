<?php

namespace App\Models\Driver;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoxDriver extends Model
{
    protected $table = 'box_driver';
    public $timestamps = false;

    use HasFactory;
    protected $fillable =  [
        'driver_id',
        'bond_type',
        'payment_type',
        'money',
        'tax',
        'total_money',
        'descrpition',
        'add_date',
        'add_by',
        'bond_state',
        'confirm_by',
        'confirm_date',
        'trustworthy_by',
        'trustworthy_date',
        'deposited_by',
        'deposit_date',
        'bank_account_number',
    ];
    protected $casts = [

        'total_money'  => "string",
        'tax'  => "string",
        'money'  => "string",
        'id'  => "string",
        ];
    public function driver(){
        return $this->belongsTo(Driver::class,  'foreign_key', 'driver_id');
    }
    public function added_by(){
        return $this->belongsTo(Admin::class,  'foreign_key', 'add_by');
    }
    public function confirmedBy(){
        return $this->belongsTo(Admin::class,  'foreign_key', 'confirm_by');
    }
    public function trusthBy(){
        return $this->belongsTo(Admin::class,  'foreign_key', 'trustworthy_by');
    }
    public function depositBy(){
        return $this->belongsTo(Admin::class,  'foreign_key', 'deposited_by');
    }
}
