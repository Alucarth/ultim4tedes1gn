<?php

use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {

    $faker->addProvider(new \Faker\Provider\Miscellaneous($faker));
    $faker->addProvider(new \Faker\Provider\Lorem($faker));

    return [
        'code'  =>  $faker->randomNumber(8, true),
        'name'  =>  $faker->countryCode,
        'description'   =>  $faker->text($maxNbChars = 50)  
    ];
});
