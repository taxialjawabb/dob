<?php

namespace App\Models\Vechile;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoxVechile extends Model
{
    public $timestamps = false; 

    protected $table = 'box_vechile';
    use HasFactory;
    protected $fillable =  [
        'vechile_id',
        'foreign_type',
        'foreign_id',
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
