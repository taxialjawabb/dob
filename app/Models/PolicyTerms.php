<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolicyTerms extends Model
{
    protected $table = 'policy_terms';
    use HasFactory;

    public $timestamps = false;

    protected $fillable =  [
        "added_by",
        "added_date",
        "belong_to",
        "type",
        "en_title",
        "ar_title",
        "en_content",
        "ar_content",
    ];

    public function add_by()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'added_by' ,'id')->select(['id', 'name']);
    }
}
