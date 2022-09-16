<?php

namespace App\Http\Controllers\controluser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
   function index()
   {

        $permissions = Cache::rememberForever('permissions', function () { 
            return DB::table('permissions')->orderBy('permission_id')->get();
        });

            // $permissions = DB::table('permissions')
            //                 ->orderBy('permission_id')
            //                 ->get();
            
        return response()->json($permissions);
   }
}
