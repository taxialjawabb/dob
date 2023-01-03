<?php

namespace App\Models\Vechile;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VechileDocuments extends Model
{
    use HasFactory;
    protected $table = 'documents_vechile';
    public $timestamps = false; 
    protected $fillable = [
        'document_type',
        'content',
        'add_date',
        'document_state',
        'admin_id',
        'vechile_id',
        'attached',
    ];
}
