<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request,UserService $userService)
    {
        $user_info = [ 
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password) 
        ];

        try{

            $userService->createUser($user_info);

            if (Auth::attempt($request->only(['email', 'password']))) {
                return response(["success" => true], 200);
            } else {
                return response(["success" => false], 403);
            }

        }catch(Exception $e){

            return response()->json('user not created. ERROR: '.$e);
        }
 
    }

    public function login(Request $request)
    {
        if (Auth::attempt($request->only(['email', 'password']))) {
            return response(["success" => true], 200);
        } else {
            return response(["success" => false], 403);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();   
       
    }
}
