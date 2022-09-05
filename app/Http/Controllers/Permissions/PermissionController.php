<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionPostRequest;
use App\Http\Resources\PermissionCollection;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct() {
    }
    public function index() {
        return PermissionCollection::collection(Permission::all());
    }
    public function edit(Request $request)
    {
        return new PermissionCollection(Permission::findOrFail($request->get('id')));
    }
    public function updateRole(PermissionPostRequest $request)
    {
        $permission = Permission::find($request->get('id'));
        $name = $request->get('name');

        $validated = $request->validated();
        if (!$validated) {
            return 'error';
        }

        $permission->name = $name;
        $permission->save();

        return $permission;
    }
    public function save(PermissionPostRequest $request)
    {
        $name = $request->get('name');
        $validated = $request->validated();

        if (!$validated) {
            return 'error';
        }

        $permission = new Permission();
        $permission->name = $name;
        $permission->save();

        return $permission;
    }
    public function destroy($id)
    {
        $permission = Permission::FindorFail($id);
        $permission->delete();
    }
}
