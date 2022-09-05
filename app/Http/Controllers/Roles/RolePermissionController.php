<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    public function updatePermissions( Request $request) {
        $role = Role::find($request->get('id'));
        if($role) {

            return "hiiii";
        }

    }
}
