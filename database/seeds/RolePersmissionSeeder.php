<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class RolePersmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['slug'=>'moderator','role_name'=>'Moderator',
                'created_at'=>date('Y-m-d h:i:s'),
                'updated_at'=>date('Y-m-d h:i:s')],
            ['slug'=>'sub-admin','role_name'=>'Sub Admin',
                'created_at'=>date('Y-m-d h:i:s'),
                'updated_at'=>date('Y-m-d h:i:s')],
            ['slug'=>'editor','role_name'=>'Editor',
                'created_at'=>date('Y-m-d h:i:s'),
                'updated_at'=>date('Y-m-d h:i:s')]
        ]);
        DB::table('permissions')->insert([
            ['slug'=>'edit','permission_name'=>'Edit',
                'created_at'=>date('Y-m-d h:i:s'),
                'updated_at'=>date('Y-m-d h:i:s')],
            ['slug'=>'add','permission_name'=>'Add',
                'created_at'=>date('Y-m-d h:i:s'),
                'updated_at'=>date('Y-m-d h:i:s')],
            ['slug'=>'delete','permission_name'=>'Delete',
                'created_at'=>date('Y-m-d h:i:s'),
                'updated_at'=>date('Y-m-d h:i:s')],
            ['slug'=>'view','permission_name'=>'View',
                'created_at'=>date('Y-m-d h:i:s'),
                'updated_at'=>date('Y-m-d h:i:s')]
        ]);
    }
}
