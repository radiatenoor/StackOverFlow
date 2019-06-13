<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(QuestionTagFaker::class);
        $this->call(AdminSeeder::class);
        $this->call(RolePersmissionSeeder::class);
    }
}
