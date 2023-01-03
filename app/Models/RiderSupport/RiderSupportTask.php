<?php

namespace App\Models\RiderSupport;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiderSupportTask extends Model
{
    protected $table = 'rider_task';
    use HasFactory;

    //public $timestamps = false; 

    protected $fillable =  [
        'department',
        'direct_by',
        'rider_id',
        'subject',
        'content',
        'state',
        'readed_date',
        'admin_id',
        'finish_date',
        'created_at',
        'updated_at',
    ];
    public function results(){
        return $this->hasMany(RiderSupportResult::class, 'task_id', 'id');
    }
}
