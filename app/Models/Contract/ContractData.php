<?php

namespace App\Models\Contract;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractData extends Model
{
    protected $table = 'contract_data';
    use HasFactory;

    public $timestamps = false; 

    protected $dates = [
        'contract_start_datetime',
        'contract_end_datetime',
   
    ];
    protected $fillable =  [
        
        'contract_number',
        'contract_start_datetime',
        'contract_end_datetime',
        'lease_term',
        'lease_cost_dar_hour',
        'contract_status',
        'contract_status_before',
        'main_financial_vat',
        'main_financial_total_lease_cost_day_hour',
        'main_financial_total',
        'add_by',
    ];
    public function contract(){
        return $this->belongsTo(\App\Models\Contract\Contract::class, 'contract_id');
    }
}
