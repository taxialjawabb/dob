<?php

namespace App\Models\RiderSupport;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiderSupportResult extends Model
{
    protected $table = 'rider_task_results';
    use HasFactory;

    public $timestamps = false; 

    protected $fillable =  [
        'add_date',
        'content',
        'task_id',
        'added_type',
        'add_by',
    ];
    public function task(){
        return $this->belongsTo(RiderSupportTask::class,  'foreign_key', 'task_id');
    }
}
