<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::get('/users', 'App\Http\Controllers\User\UserController@index');
Route::post('/user/{id}/edit', 'App\Http\Controllers\User\UserController@edit');
Route::post('/add-user', 'App\Http\Controllers\User\UserController@save');
Route::post('/update-user', 'App\Http\Controllers\User\UserController@updateUser');
Route::delete('/user/{id}', 'App\Http\Controllers\User\UserController@destroy');

Route::get('/roles', 'App\Http\Controllers\User\RoleController@index');
Route::post('/role/{id}/edit', 'App\Http\Controllers\User\RoleController@edit');
Route::post('/update-role', 'App\Http\Controllers\User\RoleController@updateRole');
Route::post('/add-role', 'App\Http\Controllers\User\RoleController@save');
Route::delete('/role/{id}', 'App\Http\Controllers\User\RoleController@destroy');

Route::get('/permissions', 'App\Http\Controllers\User\PermissionController@index')->withoutMiddleware([EnsureTokenIsValid::class]);;
Route::post('/permission/{id}/edit', 'App\Http\Controllers\User\PermissionController@edit');
Route::post('/update-permission', 'App\Http\Controllers\User\PermissionController@updateRole');
Route::post('/add-permission', 'App\Http\Controllers\User\PermissionController@save');
Route::delete('/permission/{id}', 'App\Http\Controllers\User\PermissionController@destroy');