<?php

namespace App\Models\Groups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupTax extends Model
{
    use HasFactory;
    protected $table = 'group_tax_spend';
    public $timestamps = false;
    protected $fillable = [
        'tax_year',
        'start_date',
        'end_date',
        'add_date',
        'added_by',
        'tax',
        'periodic',
        'group_id',
    ];
}
