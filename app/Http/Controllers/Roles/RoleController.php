<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Http\Requests\RolePostRequest;
use App\Models\User\Role;
use Illuminate\Http\Request;
use App\Http\Resources\RoleCollection;
use Spatie\Permission\Models\Permission;
use App\Services\Roles\RoleService;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
       // Role::with('permissions')->paginate();
        $count=$this->roleService->count(Role::all());
        return  ['roles'=>RoleCollection::collection(Role::paginate(10)),'count'=>$count];
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
        $validated = $request->validated();

        if (!$validated) {
            return 'error';
        }


       $role=$this->roleService->addRole($request);
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
        $validated = $request->validated();
        if (!$validated) {
            return 'error';
        }

        $role=$this->roleService->updateRole($request,$role);

        return $role;
    }



    public function destroy(Role $role)
    {
        $role->delete();
    }

}
