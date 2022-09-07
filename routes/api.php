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
});

/*Route::get('/users', 'App\Http\Controllers\Users\UserController@index');
Route::post('/user/{id}/edit', 'App\Http\Controllers\Users\UserController@edit');
Route::post('/add-user', 'App\Http\Controllers\Users\UserController@save');
Route::post('/update-user', 'App\Http\Controllers\Users\UserController@updateUser');
Route::delete('/user/{id}', 'App\Http\Controllers\Users\UserController@destroy');*/


Route::get('/roles', 'App\Http\Controllers\Roles\RoleController@index');
Route::post('/role/{id}/edit', 'App\Http\Controllers\Roles\RoleController@edit');
Route::post('/update-role', 'App\Http\Controllers\Roles\RoleController@updateRole');
Route::post('/add-role', 'App\Http\Controllers\Roles\RoleController@save');
Route::delete('/role/{id}', 'App\Http\Controllers\Roles\RoleController@destroy');
Route::resource( 'role/permissions', 'App\Http\Controllers\Roles\RolePermissionController@updatePermissions' );

Route::get('/permissions', 'App\Http\Controllers\Permissions\PermissionController@index');
Route::post('/permission/{id}/edit', 'App\Http\Controllers\Permissions\PermissionController@edit');
Route::post('/update-permission', 'App\Http\Controllers\Permissions\PermissionController@updateRole');
Route::post('/add-permission', 'App\Http\Controllers\Permissions\PermissionController@save');
Route::delete('/permission/{id}', 'App\Http\Controllers\Permissions\PermissionController@destroy');
