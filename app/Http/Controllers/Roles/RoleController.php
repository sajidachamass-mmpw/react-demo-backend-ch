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
     * @param  \App\Http\Requests\RolePostRequest  $request
     * @return \Illuminate\Http\Response
     */

    public function store(RolePostRequest $request)
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

    public function edit(Request $request,$id)
    {
        return new RoleCollection(Role::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\RolePostRequest  $request
     * @param  \App\Models\User\Role  $user
     * @return \Illuminate\Http\Response
     */
    public function update(RolePostRequest $request, Role $role)
    {
        $name = $request->get('name');

        $validated = $request->validated();
        if (!$validated) {
            return 'error';
        }

        $role->name = $name;
        $role->save();

        return $role;
    }



    public function destroy(Role $role)
    {
        $role->delete();
    }

}
