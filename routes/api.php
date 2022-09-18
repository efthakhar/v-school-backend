<?php

use App\Http\Controllers\controluser\PermissionController;
use App\Http\Controllers\controluser\RoleController;
use App\Http\Controllers\controluser\RolePermissionController;
use App\Http\Controllers\controluser\UserRoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




// Role 
Route::get('/roles',[RoleController::class,'index']);
Route::get('/roles/{id}',[RoleController::class,'show']);
Route::post('/roles',[RoleController::class,'store']);
Route::put('/roles/{id}',[RoleController::class,'update']);
Route::delete('/roles/{id}',[RoleController::class,'delete']);

// Role_Users
Route::get('/users-roles/user/{user_id}',[UserRoleController::class,'getRoleIdByUserId']);
Route::get('/users-roles/users/{role_id}',[UserRoleController::class,'getUsersIdsByRoleId']);
Route::post('/users-roles',[UserRoleController::class,'assignRoleToUser']);
Route::put('/users-roles',[UserRoleController::class,'updateRoleToUser']);
Route::delete('/users-roles/{user_id}',[UserRoleController::class,'deleteUserAndRole']);

// Role_Permission
Route::get('/roles_permissions/{id}',[RolePermissionController::class,'index']);
Route::post('/roles_permissions',[RolePermissionController::class,'store']);
Route::delete('/roles_permissions/{id}',[RolePermissionController::class,'delete']);

// Permission
Route::get('/permissions',[PermissionController::class,'index']);