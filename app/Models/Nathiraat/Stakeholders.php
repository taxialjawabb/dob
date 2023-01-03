<?php

namespace App\Models\Nathiraat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stakeholders extends Model
{
    protected $table = 'stakeholders';
    public $timestamps = false; 

    use HasFactory;
    protected $fillable =  [
        'name',
        'record_number',
        'expire_date',
        'add_date',
        'add_by',
        'account',
        'commerical_register',
        'id_number',
        'license_number',
        'license_category',
        'phone',
        'address',
        'company_fax',
        'email',
    ];
    protected $dates = [
        'expire_date',
    ];
    public function importsAndExports(){
        return $this->hasMany(App\Models\ImportsAndExport::class);
    }
}
