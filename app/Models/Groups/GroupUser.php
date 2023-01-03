<?php

namespace App\Models\Groups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model
{
    protected $table = 'groups_user';
    use HasFactory;

    // public $timestamps = false;

    protected $fillable =  [
        'user_id',
        'group_id',
        'state',
    ];
    public function users_group()
    {
        return $this->hasOne(\App\Models\Admin::class, 'id', 'user_id' )->select(['id', 'name']);
    }
}
