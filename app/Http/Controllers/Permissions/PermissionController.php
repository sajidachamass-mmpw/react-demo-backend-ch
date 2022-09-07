<?php

namespace App\Http\Controllers\Permissions;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionPostRequest;
use App\Http\Resources\PermissionCollection;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index() {
        return PermissionCollection::collection(Permission::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PermissionPostRequest  $request
     * @return \Illuminate\Http\Response
     */

    public function store(PermissionPostRequest $request)
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

    public function edit(Request $request,$id)
    {
        return new PermissionCollection(Permission::findOrFail($id));
    }

    public function update(PermissionPostRequest $request, Permission $permission)
    {
        $name = $request->get('name');

        $validated = $request->validated();
        if (!$validated) {
            return 'error';
        }

        $permission->name = $name;
        $permission->save();

        return $permission;
    }



    public function destroy(Permission $permission)
    {
        $permission->delete();
    }
}
