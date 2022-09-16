<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cache::forget('permissions');

        DB::table('permissions')->truncate();

        $permissions = [

            [ 'permission_id' => 1,'permission_name' => 'view_user'],
            [ 'permission_id' => 2,'permission_name' => 'create_user'],
            [ 'permission_id' => 3,'permission_name' => 'update_user'],
            [ 'permission_id' => 4,'permission_name' => 'delete_user'],

            [ 'permission_id' => 5,'permission_name' => 'view_role'],
            [ 'permission_id' => 6,'permission_name' => 'create_role'],
            [ 'permission_id' => 7,'permission_name' => 'update_role'],
            [ 'permission_id' => 8,'permission_name' => 'delete_role'],
           
         ];

        foreach($permissions as $permission){

            DB::table('permissions')->insert($permission);
        }

        //php artisan db:seed --class=PermissionSeeder
    }
}
