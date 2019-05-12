<?php

use Faker\Generator as Faker;

$factory->define(App\Answer::class, function (Faker $faker) {
    return [
        'question_id'=>rand(2,5),
        'user_id'=>1,
        'answer'=>$faker->paragraph,
        'status'=>1,
        'created_at'=>date('Y-m-d h:i:s'),
        'updated_at'=>date('Y-m-d h:i:s')
    ];
});
