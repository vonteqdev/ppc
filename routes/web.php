<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ImpersonateController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\ProductsController;


Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::group(['prefix'=>'users'], function(){
        Route::get('/',                             [UsersController::class, 'index'])->name('users.index')->middleware('checkPermissions:read_users');
        Route::get('/create',                       [UsersController::class, 'create'])->name('users.create')->middleware('checkPermissions:write_users');
        Route::post('/create',                      [UsersController::class, 'store'])->name('users.store')->middleware('checkPermissions:write_users');
        Route::get('/{user}',                       [UsersController::class, 'show'])->name('users.show')->middleware('checkPermissions:read_users');
        Route::put('/{user}',                       [UsersController::class, 'update'])->name('users.update')->middleware('checkPermissions:edit_users');
        Route::delete('/{user}',                    [UsersController::class, 'destroy'])->name('users.destroy')->middleware('checkPermissions:delete_users');

        Route::get('/impersonate/{user}',           [ImpersonateController::class, 'impersonate'])->name('users.impersonate')->middleware('checkPermissions:impersonate_users');
        Route::get('/stop/impersonate',             [ImpersonateController::class, 'stopImpersonate'])->name('users.stop-impersonate');
    });

    Route::group(['prefix'=>'setup'], function(){
        Route::get('/',                             [SetupController::class, 'index'])->name('setup.index')->middleware('checkPermissions:read_setup');
    });

    Route::group(['prefix'=>'roles'], function(){
        Route::get('/',                 [RoleController::class, 'index'])->name('roles.index')->middleware('checkPermissions:read_roles');
        Route::get('/create',           [RoleController::class, 'create'])->name('roles.create')->middleware('checkPermissions:write_roles');
        Route::post('/create',          [RoleController::class, 'store'])->name('roles.store')->middleware('checkPermissions:write_roles');
        Route::get('/{role}',           [RoleController::class, 'show'])->name('roles.show')->middleware('checkPermissions:read_roles');
        Route::put('/{role}',           [RoleController::class, 'update'])->name('roles.update')->middleware('checkPermissions:edit_roles');
        Route::delete('/{role}',        [RoleController::class, 'destroy'])->name('roles.destroy')->middleware('checkPermissions:delete_roles');
    });

    Route::group(['prefix'=>'products'], function(){
        Route::get('/',                 [ProductsController::class, 'index'])->name('products.index')->middleware('checkPermissions:read_products');
        Route::get('/create',           [ProductsController::class, 'create'])->name('products.create')->middleware('checkPermissions:write_products');
        Route::post('/create',          [ProductsController::class, 'store'])->name('products.store')->middleware('checkPermissions:write_products');
        Route::get('/{product}',        [ProductsController::class, 'show'])->name('products.show')->middleware('checkPermissions:read_products');
        Route::put('/{product}',        [ProductsController::class, 'update'])->name('products.update')->middleware('checkPermissions:edit_products');
        Route::delete('/{product}',     [ProductsController::class, 'destroy'])->name('products.destroy')->middleware('checkPermissions:delete_products');
    });
    
    Route::group(['prefix'=>'permissions'], function(){
        Route::get('/',                 [PermissionController::class, 'index'])->name('permissions.index')->middleware('checkPermissions:read_permissions');
        Route::get('/{permission}',     [PermissionController::class, 'show'])->name('permissions.show')->middleware('checkPermissions:read_permissions');
    });
});

require __DIR__.'/auth.php';
