<?php

namespace App\Services\Permissions;

use Spatie\Permission\Models\Permission;

/**
 * Class PermissionService
 * @package App\Services
 */
class PermissionService
{
    public function count($permissions){
        return $permissions->count();
    }

    public function addPermission($request){

        $name = $request->get('name');
        $permission = new Permission();
        $permission->name = $name;
        $permission->save();

        return $permission;
    }

    public function updatePermission($request,$permission){

        $name = $request->get('name');

        $permission->name = $name;
        $permission->save();

        return $permission;
    }

}
