<?php

namespace App\Http\Controllers\controluser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserRoleController extends Controller
{

    // get role id by user id
    function getRoleIdByUserId($user_id)
    {
        $role_id = DB::table('users_roles')
                   ->where('user_id',$user_id)
                   ->value('role_id');
        if($role_id){
            return response()->json(['role_id'=> $role_id]);
        }else{
            return response()->json(['role_id'=> null]);
        }           
    }

    // get all users of specific role id
    function getUsersIdsByRoleId($role_id)
    {
        $users = DB::table('users_roles')
                    ->where('role_id',$role_id)
                    ->get();
        if($users){
            return response()->json($users);
        }else{
            return response()->json('no user found of this role');
        }           
    }

    // assign specific role id to specific user id
    function assignRoleToUser(Request $request)
    {
        $assign_role = DB::table('users_roles')
                       ->insert([
                        'user_id'=>$request->user_id, 
                        'role_id'=>$request->role_id
                        ]);

        if($assign_role){

            return response()->json([
                'success' => true,
                'message' => 'role assigned to user'
            ]);

        }else{

            return response()->json([
                'success' => false,
                'message' => 'role not assigned to user'
            ]);
        }                 
    }

    // update specific role id to specific user id
    function updateRoleToUser(Request $request)
    {
        $assign_role = DB::table('users_roles')
                       ->where('user_id',$request->user_id)
                       ->update([
                        'user_id'=>$request->user_id, 
                        'role_id'=>$request->role_id
                        ]);

        if($assign_role){

            return response()->json([
                'success' => true,
                'message' => 'role updated to user'
            ]);

        }else{

            return response()->json([
                'success' => false,
                'message' => 'role not updated to user'
            ]);
        }                 
    }

    // delete user role record by user id
    function deleteUserAndRole($user_id){

        $delete = DB::table('users_roles')
                  ->where('user_id',$user_id)
                  ->delete();

        if($delete){

            return response()->json([
                'success' => true,
                'message' => 'user and corresponding role record deleted'
            ]);

        }else{

            return response()->json([
                'success' => false,
                'message' => 'user and corresponding role record fail to delete'
            ]);
        } 

    }

}
