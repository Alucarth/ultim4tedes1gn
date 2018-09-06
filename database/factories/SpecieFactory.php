<?php

use Faker\Generator as Faker;

$factory->define(App\Specie::class, function (Faker $faker) {

    $faker->addProvider(new \Faker\Provider\Internet($faker));

    return [        
        'name'  =>  $faker->userName,
        'description'   =>  $faker->text($maxNbChars = 50)  
    ];
});
