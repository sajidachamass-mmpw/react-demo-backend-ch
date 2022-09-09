<?php

namespace App\Services\Roles;

use App\Models\User\Role;

/**
 * Class RoleService
 * @package App\Services
 */
class RoleService
{
    public function count($roles){
        return $roles->count();
    }

    public function addRole($request){

        $name = $request->get('name');

        $role = new Role();
        $role->name = $name;
        $role->guard_name = 'web';
        $role->save();

        return $role;
    }

    public function updateRole($request,$role){

        $name = $request->get('name');

        $role->name = $name;
        $role->save();

        return $role;
    }


}
