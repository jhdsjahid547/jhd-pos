<?php

use Illuminate\Support\Facades\Route;
use Modules\Permission\Http\Controllers\EmployeeController;
use Modules\Permission\Http\Controllers\PermissionController;
use Modules\Permission\Http\Controllers\RoleController;

/*Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('permissions', PermissionController::class)->names('permission');
});*/

Route::middleware(['auth'])->prefix('permission')->as('permission.')->group(function () {
    Route::resource('access', PermissionController::class)->names('access');
    Route::resource('roles', RoleController::class)->names('roles')->except(['create', 'edit']);
    Route::put('/roles/{role}/permissions', [RoleController::class, 'updateRolePermissions'])->name('roles.update-permissions');
    Route::resource('employees', EmployeeController::class)->names('employees');
});

