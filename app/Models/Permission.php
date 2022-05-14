<?php

namespace App\Models;

use Laratrust\Models\LaratrustPermission;

class Permission extends LaratrustPermission
{
    public $guarded = [];

    public function roles() 
    {
        return $this->belongsToMany('App\Models\Role', 'permission_role','permission_id', 'role_id', 'id','id');
    }
}
