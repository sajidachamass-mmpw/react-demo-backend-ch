<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group( function () {
    Route::resource( 'users', 'App\Http\Controllers\Users\UserController' );

    Route::resource( 'roles', 'App\Http\Controllers\Roles\RoleController' );
    Route::resource( 'rolePermissions', 'App\Http\Controllers\Roles\RolePermissionController' );

    Route::resource( 'permissions', 'App\Http\Controllers\Permissions\PermissionController');
});

