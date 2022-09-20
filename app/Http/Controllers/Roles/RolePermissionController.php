<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request) {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return void
     */
    public function update( Request $request, $id ) {
        $role = Role::find($id);
        if($role) {
            if ($request->has('permissions')) {
                $permissions_checked = $request->get('permissions');

                $permissions = Permission::whereIn('id', $permissions_checked)->get();

                $role->syncPermissions($permissions);
            } else {
                $permissions = Permission::all();

                foreach ($permissions as $permission) {
                    $role->revokePermissionTo($permission->name);
                }
            }

            return $role;
        }
        else {
            return '404 Error';
        }

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id ) {
        //
    }
}
