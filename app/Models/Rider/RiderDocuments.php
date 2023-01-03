<?php

namespace App\Models\Rider;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiderDocuments extends Model
{
    use HasFactory;
    protected $table = 'documents_rider';
    public $timestamps = false; 
    protected $fillable = [
        'document_type',
        'content',
        'add_date',
        'document_state',
        'admin_id',
        'rider_id',
        'attached',
    ];
}
