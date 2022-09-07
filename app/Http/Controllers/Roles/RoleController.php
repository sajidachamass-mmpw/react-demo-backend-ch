<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Http\Requests\RolePostRequest;
use App\Models\User\Role;
use Illuminate\Http\Request;
use App\Http\Resources\RoleCollection;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
       // Role::with('permissions')->paginate();
        return RoleCollection::collection(Role::all());
    }

    public function edit(Request $request)
    {
        return new RoleCollection(Role::findOrFail($request->get('id')));
    }

    public function updateRole(RolePostRequest $request)
    {
        $role = Role::find($request->get('id'));
        $name = $request->get('name');

        $validated = $request->validated();
        if (!$validated) {
            return 'error';
        }

        $role->name = $name;
        $role->save();

        return $role;
    }

    public function save(RolePostRequest $request)
    {

        $name = $request->get('name');
        $validated = $request->validated();

        if (!$validated) {
            return 'error';
        }

        $role = new Role();
        $role->name = $name;
        $role->guard_name = 'web';
        $role->save();

        return $role;
    }

    public function destroy($id)
    {
        $role = Role::FindorFail($id);
        $role->delete();
    }

}
