<?php

use App\Http\Controllers\controluser\PermissionController;
use App\Http\Controllers\controluser\RoleController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Role 
Route::get('/roles',[RoleController::class,'index']);
Route::get('/roles/{id}',[RoleController::class,'show']);
Route::post('/roles',[RoleController::class,'store']);
Route::put('/roles/{id}',[RoleController::class,'update']);
Route::delete('/roles/{id}',[RoleController::class,'delete']);

// Permission
Route::get('/permissions',[PermissionController::class,'index']);