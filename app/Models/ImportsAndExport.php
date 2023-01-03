<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportsAndExport extends Model
{
    protected $table = 'import_export';
    use HasFactory;

    public $timestamps = false; 

    protected $fillable =  [
        'title',
        'content',
        'type',
        'add_date',
        'added_by',
        'stakeholder_id',
        'attached',
    ];

    public function stakeholder(){
        return $this->belongsTo(\App\Models\Nathiraat\Stakeholders::class, 'stakeholder_id');
    }
}
