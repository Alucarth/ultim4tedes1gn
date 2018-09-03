<?php

use Faker\Generator as Faker;

$factory->define(App\Type::class, function (Faker $faker) {

    $faker->addProvider(new \Faker\Provider\Miscellaneous($faker));
    $faker->addProvider(new \Faker\Provider\Lorem($faker));
    $faker->addProvider(new \Faker\Provider\Base($faker));

    return [        
        'name'  =>  $faker->randomLetter,
        'description'   =>  $faker->text($maxNbChars = 50)  
    ];
});
