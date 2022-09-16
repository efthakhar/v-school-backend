<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    function index()
    {
        $roles = DB::table('roles')->get()->keyBy('role_id');

        return response()->json($roles);
    }

    function show($id)
    {
        $role = DB::table('roles')->where('role_id',$id)->first();

        if($role){
            return response()->json($role);
        }else{
            return response()->json([
                'success'=> false,
                'message'=> 'role not found'
            ]);
        }

      
    }

    function store(Request $request)
    {
        $role =  DB::table('roles')
                    ->insert([
                        'role_name'=> $request->role_name,
                        'default'  => $request->default?  $request->default : 0
                    ]);

        if($role){
            return response()->json([
                'success' => true,
                'message' => 'role created'
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'fail to create role'
            ]);
        }            
    }


    function update(Request $request,$id)
    {  
         
        $role =  DB::table('roles')
                    ->where('role_id',$id)
                    ->update([
                        'role_name'=> $request->role_name,
                        'default'  => $request->default?  $request->default : 0
                    ]);

        if($role){
            return response()->json([
                'success' => true,
                'message' => 'role updated'
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'fail to update role'
            ]);
        }            
    }

    function delete($id)
    {
        $delete = DB::table('roles')->where('role_id',$id)->delete();

        if($delete){
            return response()->json([
                'success'=> true,
                'message'=> 'role deleted'
            ]);
        }else{
            return response()->json([
                'success'=> false,
                'message'=> 'role fail to delete'
            ]);
        }
    }


}
