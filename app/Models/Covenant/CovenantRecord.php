<?php

namespace App\Models\Covenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CovenantRecord extends Model
{
    protected $table = 'covenant_record';
    use HasFactory;

    public $timestamps = false; 

    protected $fillable =  [
        'forign_type',
        'forign_id',
        'item_id',
        'delivery_date',
        'delivery_by',
        'receive_date',
        'receive_by'
    ];

}
