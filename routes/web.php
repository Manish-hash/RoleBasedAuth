<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('role:admin')->group(function () {
    Route::middleware('isAdmin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::resource('permissions', PermissionController::class );
    Route::get('permissions/{id}/delete', [PermissionController::class,'destroy']);
    
    Route::resource('roles', RoleController::class );
    Route::get('roles/{id}/delete', [RoleController::class,'destroy']);
    Route::get('roles/{id}/give-permissions', [RoleController::class,'addPermissionToRole']);
    Route::put('roles/{id}/give-permissions', [RoleController::class,'givePermissionToRole']);
    
    Route::resource('users', UserController::class );
    Route::get('users/{userId}/delete', [UserController::class,'destroy']);
});



require __DIR__.'/auth.php';
