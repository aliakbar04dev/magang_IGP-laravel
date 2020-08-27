<?php

namespace App;

use Laratrust\LaratrustRole;

class Role extends LaratrustRole
{
    public function getPermissionnameAttribute()
    {
        $permissionnames = [];
        $permissions = $this->permissions()->get();
        foreach ($permissions as $permission) {
            array_push($permissionnames, $permission->name);
        }
        return $permissionnames;
    }
}
