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
        'high'  =>  number_format((float)$faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 9999), 2, '.', ''),
        'wide'  =>  number_format((float)$faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 9999), 2, '.', ''),
        'length'  =>  number_format((float)$faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 9999), 2, '.', ''),
        'description'   =>  $faker->text($maxNbChars = 50)          
    ];
});
