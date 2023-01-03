<?php

namespace App\Models\Rider;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoxRider extends Model
{
    public $timestamps = false; 

    protected $table = 'box_rider';
    use HasFactory;
    protected $fillable =  [
        'rider_id',
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
    public function added_by(){
        return $this->belongsTo(\App\Models\Admin::class,  'foreign_key', 'add_by');
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
