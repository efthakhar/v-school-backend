<?php 

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\DB;

class UserService {

    function getAllUsers()
    {
        $users = DB::table('users')->get()->keyBy('id');
        return $users;
    }

    function getUserById($user_id)
    {
         return  $users = DB::table('users')->find($user_id);
    }

    function createUser($user_info)
    {
        $created_user_id = DB::table('users')->insertGetId($user_info);
        return $created_user_id;     
    }

    function updateUser($user_info,$user_id)
    {
        $updated = DB::table('users')->where('id',$user_id)->update($user_info);
        return $updated;
    }

    function deleteUser($user_id)
    {
      $deleted =  DB::table('users')->where('id',$user_id)->delete();
      return $deleted;
    }
}