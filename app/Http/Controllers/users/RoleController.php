<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    function index()
    {
        $roles = DB::table('roles')->get()->keyBy('role_name');

        return response()->json($roles);
    }
}
