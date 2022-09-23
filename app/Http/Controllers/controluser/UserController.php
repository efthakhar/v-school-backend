<?php

namespace App\Http\Controllers\controluser;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function index(UserService $userService)
    {    
            $users = $userService->getAllUsers();

            return response()->json($users);
    }
    
    function show(UserService $userService,$user_id)
    {
        return $user = $userService->getUserById($user_id);

    }

    function store(Request $request,UserService $userService)
    {
            $user_info = [ 
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password) 
            ];

            try{

                $userService->createUser($user_info);
                return response()->json('user created'); 

            }catch(Exception $e){

                return response()->json('user not created. ERROR: '.$e);
            }

            
    }

    function update(Request $request,UserService $userService,$user_id)
    {
            $user_info = [                  
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password) 
            ];

            try{        

                $userService->updateUser( $user_info, $user_id); 
                return response()->json('user updated'); 

            }catch(Exception $e){

                return response()->json('user not updated. Error: '.$e);
            }
    }

    function delete(UserService $userService,$user_id)
    {
        try{
            $userService->deleteUser($user_id);
            return response()->json('user deleted');
        }catch(Exception $e){
            return response()->json('user not deleted. Error:'.$e);
        }
    }


}
