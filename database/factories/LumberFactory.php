<?php

use Faker\Generator as Faker;

$factory->define(App\Lumber::class, function (Faker $faker) {

    $faker->addProvider(new \Faker\Provider\Lorem($faker));

    $qualities = App\Quality::get()->all();
    $species = App\Specie::get()->all();

    return [
        'code'  =>  $faker->randomNumber(8, true),
        'quality_id'    =>  $qualities[array_rand($qualities)]->id,
        'specie_id'    =>  $species[array_rand($species)]->id,
        'high'  =>  $faker->randomNumber($nbDigits = 3, $strict = false),
        'wide'  =>  $faker->randomNumber($nbDigits = 3, $strict = false),
        'length'  =>  $faker->randomNumber($nbDigits = 3, $strict = false),
        'description'   =>  $faker->text($maxNbChars = 50)          
    ];
});
