<?php

namespace App\Models\Nathiraat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class StakeholdersDocuments extends Model
{
    protected $table = 'documents_nathriaat';
    public $timestamps = false; 

    use HasFactory;
    protected $fillable =  [
        'document_type',
        'content',
        'add_date',
        'document_state',
        'admin_id',
        'nathriaat_id',
        'attached',
    ];

}
