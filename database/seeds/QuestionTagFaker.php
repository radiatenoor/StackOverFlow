<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class QuestionTagFaker extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$faker = \Faker\Factory::create();
        foreach (range(1,12) as $index){
            DB::table('question_tags')->insert([
                'question_id'=>rand(2,21),
                'tag_id'=>rand(1,3),
                'created_at'=>date('Y-m-d h:i:s'),
                'updated_at'=>date('Y-m-d h:i:s')
            ]);
        }
    }
}
