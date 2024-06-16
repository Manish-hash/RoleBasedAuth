<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('permissions', PermissionController::class );
Route::get('permissions/{id}/delete', [PermissionController::class,'delete']);

Route::resource('roles', RoleController::class );
Route::get('roles/{id}/delete', [RoleController::class,'delete']);
Route::get('roles/{id}/give-permissions', [RoleController::class,'addPermissionToRole']);
Route::put('roles/{id}/give-permissions', [RoleController::class,'givePermissionToRole']);

Route::resource('users', UserController::class );