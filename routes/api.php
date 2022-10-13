<?php

use App\Http\Controllers\academic\BuildingController;
use App\Http\Controllers\academic\ClassController;
use App\Http\Controllers\academic\RoomController;
use App\Http\Controllers\academic\SectionController;
use App\Http\Controllers\academic\SessionController;
use App\Http\Controllers\controluser\PermissionController;
use App\Http\Controllers\controluser\RoleController;
use App\Http\Controllers\controluser\RolePermissionController;
use App\Http\Controllers\controluser\UserController;
use App\Http\Controllers\controluser\UserRoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' =>'auth:sanctum'], function() {

    
    //User
    Route::get('/users',[UserController::class,'index']);
    Route::get('/users/{id}',[UserController::class,'show']);
    Route::post('/users',[UserController::class,'store']);
    Route::put('/users/{id}',[UserController::class,'update']);
    Route::delete('/users/{id}',[UserController::class,'delete']);

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

    // Session
    Route::get('/sessions',[SessionController::class,'index']);
    Route::get('/sessions/list',[SessionController::class,'list']);
    Route::get('/sessions/{id}',[SessionController::class,'show']);
    Route::post('/sessions',[SessionController::class,'store']);
    Route::put('/sessions/{id}',[SessionController::class,'update']);
    Route::delete('/sessions/{id}',[SessionController::class,'delete']);

    
    // Class
    Route::get('/classes',[ClassController::class,'index']);
    Route::get('/classes/{id}',[ClassController::class,'show']);
    Route::post('/classes',[ClassController::class,'store']);
    Route::put('/classes/{id}',[ClassController::class,'update']);
    Route::delete('/classes/{id}',[ClassController::class,'delete']);
        

    // // Section    
    // Route::get('/sections',[SectionController::class,'index']);
    // Route::get('/sections/{id}',[SectionController::class,'show']);
    // Route::post('/sections',[SectionController::class,'store']);
    // Route::put('/sections/{id}',[SectionController::class,'update']);
    // Route::delete('/sections/{id}',[SectionController::class,'delete']);
    
    // Building
    Route::get('/buildings',[BuildingController::class,'index']);
    Route::get('/buildings/list',[BuildingController::class,'getAll']);
    Route::get('/buildings/{id}',[BuildingController::class,'show']);
    Route::post('/buildings',[BuildingController::class,'store']);
    Route::put('/buildings/{id}',[BuildingController::class,'update']);
    Route::delete('/buildings/{id}',[BuildingController::class,'delete']);

    
    // Rooms
    Route::get('/rooms',[RoomController::class,'index']);
    Route::get('/rooms/{id}',[RoomController::class,'show']);
    Route::post('/rooms',[RoomController::class,'store']);
    Route::put('/rooms/{id}',[RoomController::class,'update']);
    Route::delete('/rooms/{id}',[RoomController::class,'delete']);
        


});
    // Section    
    Route::get('/sections',[SectionController::class,'index']);
    Route::get('/sections/{id}',[SectionController::class,'show']);
    Route::post('/sections',[SectionController::class,'store']);
    Route::put('/sections/{id}',[SectionController::class,'update']);
    Route::delete('/sections/{id}',[SectionController::class,'delete']);