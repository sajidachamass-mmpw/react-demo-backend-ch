<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\Role;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class RoleController extends Controller
{
    public function index() {
        $roles = Role::all();
        return $roles;
    }
}