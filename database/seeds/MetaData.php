<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class MetaData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*category table seed*/
        DB::table('categories')->insert([
            [
                'name'=>'Web Development',
                'created_at'=>date('Y-m-d h:i:s'),
                'updated_at'=>date('Y-m-d h:i:s')
            ],
            [
                'name'=>'Mobile Development',
                'created_at'=>date('Y-m-d h:i:s'),
                'updated_at'=>date('Y-m-d h:i:s')
            ],
            [
                'name'=>'Graphics',
                'created_at'=>date('Y-m-d h:i:s'),
                'updated_at'=>date('Y-m-d h:i:s')
            ]
        ]);
        /*tag table seed*/
        DB::table('tags')->insert([
            [
                'name'=>'PHP',
                'created_at'=>date('Y-m-d h:i:s'),
                'updated_at'=>date('Y-m-d h:i:s')
            ],
            [
                'name'=>'JAVA',
                'created_at'=>date('Y-m-d h:i:s'),
                'updated_at'=>date('Y-m-d h:i:s')
            ],
            [
                'name'=>'JavaScript',
                'created_at'=>date('Y-m-d h:i:s'),
                'updated_at'=>date('Y-m-d h:i:s')
            ]
            ,
            [
                'name'=>'Laravel',
                'created_at'=>date('Y-m-d h:i:s'),
                'updated_at'=>date('Y-m-d h:i:s')
            ]
        ]);
    }
}
