<?php

namespace App\Models\Groups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupsLicenses extends Model
{
    use HasFactory;
    protected $table = 'groups_licenses';
    public $timestamps = false;
    protected $fillable = [
        'type',
        'state',
        'expire_date',
        'accept_date',
        'accepted_by',
        'document_id',
    ];
}
