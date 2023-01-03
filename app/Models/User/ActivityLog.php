<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'activity_log';

    public $timestamps = false;
    protected $dates = [
        'created_at'
    ];
    protected $fillable = [
        'admin_id',
        'created_at',
        'log_type',
        'code',
        'ip',
        'address',
        'location',
    ];
    public function admin_data(){
        return $this->belongsTo(\App\Models\Admin::class,  'admin_id')->select([ 'id', 'name']);
    }
}
