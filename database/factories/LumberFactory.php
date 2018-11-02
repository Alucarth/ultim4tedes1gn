<?php

use Faker\Generator as Faker;

$factory->define(App\Lumber::class, function (Faker $faker) {

    $faker->addProvider(new \Faker\Provider\Lorem($faker));

    $types = App\Type::get()->all();
    $species = App\Specie::get()->all();
    $unit = App\Unit::get()->all();
    
    return [        
        'type_id'    =>  $types[array_rand($types)]->id,
        'specie_id'    =>  $species[array_rand($species)]->id,
        'unit_id'    =>  $unit[array_rand($unit)]->id,
        'high'  =>  number_format((float)$faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 9999), 2, '.', ''),
        'width'  =>  number_format((float)$faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 9999), 2, '.', ''),
        'density'  =>  number_format((float)$faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 9999), 2, '.', ''),
        'description'   =>  $faker->text($maxNbChars = 50)          
    ];
});
