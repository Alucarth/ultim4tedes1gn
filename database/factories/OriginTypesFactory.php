<?php

use Faker\Generator as Faker;

$factory->define(App\OriginType::class, function (Faker $faker) {
    return [
        // 
        'name'=> $faker->name,
        'description'=> $faker->text($maxNbChars = 50)
    ];
});
