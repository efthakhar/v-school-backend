<?php

namespace App\Http\Controllers\controluser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolePermissionController extends Controller
{
    // get all permission ids of specific role id
    function index($role_id)
    {
        $permission_ids = DB::table('roles_permissions')
                          ->where('role_id',$role_id)
                          ->first();
        return response()->json($permission_ids);                  
    }

    // assign permissions to specific role id
    function store(Request $request)
    {
        $assing_permissions = DB::table('roles_permissions')
        ->upsert(
                [
                    ['role_id'=>$request->role_id, 'permission_ids'=>$request->permission_ids]
                ],
                ['role_id' ],
                ['permission_ids']
          );

         if($assing_permissions){
            return response()->json('permission stored');
         }else{
            return response()->json('permission not stored');
         } 
    }

    // delete role_permission pair record
    function delete($role_id)
    {
        $delete = DB::table('roles_permissions')
                  ->where('role_id',$role_id)
                  ->delete();
        if($delete){
        return response()->json('role and corresponding permission record deleted');
        }else{
        return response()->json('role and corresponding permission record not deleted');
        }            
    }
}
