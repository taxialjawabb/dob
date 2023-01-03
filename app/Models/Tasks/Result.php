<?php

namespace App\Models\Tasks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $table = 'results';
    use HasFactory;

    public $timestamps = false; 

    protected $fillable =  [
        'add_date',
        'content',
        'task_id',
        'add_by',
    ];
    public function task(){
        return $this->belongsTo(Task::class,  'foreign_key', 'task_id');
    }
}
