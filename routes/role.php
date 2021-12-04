<?php

use Illuminate\Support\Facades\Route;
use Samchentw\Permission\Http\Controllers\API\RoleController;




//角色 Api
if (config('permissionmap.role_api_enable', false)) {
    Route::prefix('role')->name('role.')->middleware(['api'])->group(function () {
        // 取得所有權限資料
        Route::get('get-all-permission', [RoleController::class, 'getAllPermission']);
        // 取得所有角色
        Route::get('', [RoleController::class, 'getAll'])->name('getAll');
        // 取得角色
        Route::get('{id}', [RoleController::class, 'get'])->name('get');
        // 新增角色
        Route::post('', [RoleController::class, 'store'])->middleware(['can:Page.Role.Create'])->name('store');
        // 修改角色
        Route::put('{id}', [RoleController::class, 'update'])->middleware(['can:Page.Role.Update'])->name('update');
        // 刪除角色
        Route::delete('{id}', [RoleController::class, 'delete'])->middleware(['can:Page.Role.Delete'])->name('delete');
    });
}
