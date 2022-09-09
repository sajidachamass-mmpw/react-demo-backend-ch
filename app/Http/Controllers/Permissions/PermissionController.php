<?php

namespace App\Http\Controllers\Permissions;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionPostRequest;
use App\Http\Resources\PermissionCollection;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Services\Permissions\PermissionService;

class PermissionController extends Controller
{

    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index() {
        $count=$this->permissionService->count(Permission::all());
        return  ['permissions'=>PermissionCollection::collection(Permission::paginate(10)),'count'=>$count];
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

        $validated = $request->validated();

        if (!$validated) {
            return 'error';
        }

       $permission=$this->permissionService->addPermission($request);

        return $permission;
    }

    public function edit(Request $request,$id)
    {
        return new PermissionCollection(Permission::findOrFail($id));
    }

    public function update(PermissionPostRequest $request, Permission $permission)
    {
        $validated = $request->validated();
        if (!$validated) {
            return 'error';
        }

        $permission=$this->permissionService->UpdatePermission($request,$permission);
        return $permission;
    }



    public function destroy(Permission $permission)
    {
        $permission->delete();
    }
}
