<?php

namespace App\Models;

use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    public $guarded = [];

    public function permission() 
    {
        return $this->belongsToMany('App\Models\Permission', 'permission_role', 'role_id','permission_id', 'id','id');
    }
}
