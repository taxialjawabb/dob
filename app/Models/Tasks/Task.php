<?php

namespace App\Models\Tasks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';
    use HasFactory;

    public $timestamps = true; 

    protected $fillable =  [
        'department',
        'add_by',
        'subject',
        'content',
        'state',
        'added_date',
        'readed_by',
        'readed_date',
        'finish_date',
    ];
    public function results(){
        return $this->hasMany(Result::class, 'task_id', 'id');
    }
}
