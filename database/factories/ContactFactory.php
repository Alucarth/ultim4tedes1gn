<?php

use Faker\Generator as Faker;

$factory->define( App\Contact::class, function (Faker $faker) {
    $providers = App\Provider::get()->all();
    $faker->addProvider(new \Faker\Provider\en_US\Company($faker));
    $faker->addProvider(new \Faker\Provider\en_US\Person($faker));
    $faker->addProvider(new \Faker\Provider\en_US\Address($faker));
    $faker->addProvider(new \Faker\Provider\Miscellaneous($faker));
  
    return [
        //
        'provider_id'    =>  $providers[array_rand($providers)]->id,
        'is_primary'    =>  $faker->boolean,
        'first_name'    =>  $faker->firstName,
        'last_name'    =>  $faker->lastName,
        'email'    =>  $faker->safeEmail,
        'phone'    =>  $faker->randomDigit,
        'position'    =>  $faker->state
    ];
});
