<?php

namespace App\Models\Driver;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverDocuments extends Model
{
    use HasFactory;
    protected $table = 'documents_driver';
    public $timestamps = false; 
    protected $fillable = [
        'document_type',
        'content',
        'add_date',
        'document_state',
        'admin_id',
        'driver_id',
        'attached',
    ];
}
