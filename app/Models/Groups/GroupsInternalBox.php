<?php

namespace App\Models\Groups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupsInternalBox extends Model
{
    protected $table = 'group_internal_box';
    public $timestamps = false;

    use HasFactory;

    protected $fillable =  [
        'foreign_type',
        'foreign_id',
        'group_id',
        'bond_type',
        'payment_type',
        'money',
        'tax',
        'total_money',
        'descrpition',
        'add_date',
        'add_by',
        'bond_state',
        'deposited_by',
        'deposit_date',
        'bank_account_number',
    ];
    protected $dates= [
        'add_date'
    ];
    public function driver(){
        return $this->belongsTo(Driver::class,  'foreign_key', 'driver_id');
    }
    public function added_by(){
        return $this->belongsTo(Admin::class,  'foreign_key', 'add_by');
    }

}
