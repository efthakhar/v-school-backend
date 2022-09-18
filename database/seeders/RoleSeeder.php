<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $default_roles = [
            [ 'role_id' => 1,'role_name' => 'super_admin','default' => 1 ],
            [ 'role_id' => 2,'role_name' => 'admin' ,'default' => 1  ],
            [ 'role_id' => 3,'role_name' => 'teacher','default' => 1  ],
            [ 'role_id' => 4,'role_name' => 'student' ,'default' => 1 ],
            [ 'role_id' => 5,'role_name' => 'guardian' ,'default' => 1 ],
            [ 'role_id' => 6,'role_name' => 'librarian' ,'default' => 1 ],
            [ 'role_id' => 7,'role_name' => 'accountant','default' => 1  ],
            [ 'role_id' => 8,'role_name' => 'receptionist','default' => 1  ],
         ];
 
         foreach($default_roles as $role){
 
             DB::table('roles')->insert($role);
         }
 
    }
}
