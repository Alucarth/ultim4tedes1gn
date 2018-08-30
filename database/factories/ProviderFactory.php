<?php

use Faker\Generator as Faker;

$factory->define(App\Provider::class, function (Faker $faker) {
    $faker->addProvider(new \Faker\Provider\en_US\Company($faker));
    $faker->addProvider(new \Faker\Provider\en_US\Person($faker));
    return [
        'code'  =>  $faker->randomNumber(8, true),
        'name'  =>  $faker->lastname.' '.$faker->firstname('male'),
        'origin'    =>  $faker->unique()->company
    ];
});
