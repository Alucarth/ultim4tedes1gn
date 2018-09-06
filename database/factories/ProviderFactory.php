<?php

use Faker\Generator as Faker;

$factory->define(App\Provider::class, function (Faker $faker) {
    $faker->addProvider(new \Faker\Provider\en_US\Company($faker));
    $faker->addProvider(new \Faker\Provider\en_US\Person($faker));
    return [
       
        'name'  =>  $faker->lastname.' '.$faker->firstname('male'),
        'offer'  =>  $faker->lastname.' '.$faker->firstname('male'),
        'description'  =>  $faker->text,
        'address1'    =>  $faker->address,
        'address2'    =>  $faker->address,
        'city'    =>  $faker->city,
        'balance'    =>  $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = NULL),
        'debit'    =>  $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = NULL)
    ];

});
