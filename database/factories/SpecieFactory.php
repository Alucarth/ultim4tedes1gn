<?php

use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {

    $faker->addProvider(new \Faker\Provider\Internet($faker));

    return [
        'code'  =>  $faker->randomNumber(8, true),
        'name'  =>  $faker->userName,
        'description'   =>  $faker->text($maxNbChars = 50)  
    ];
});
