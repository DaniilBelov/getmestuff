<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'token' => str_random(30),
        'remember_token' => str_random(10),
        'ref_link' => str_random(5),
        'locale' => 'en'
    ];
});

/**
 * @param \Faker\Generator $faker
 * @return array
 */
$factory->define(App\Wish::class, function (Faker\Generator $faker) {
    return [
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'url' => $faker->url,
        'address' => [
            'address_one' => $faker->streetAddress,
            'address_two' => null,
            'city' => $faker->city,
            'post_code' => $faker->postcode,
            'country' => $faker->country
        ],
        'current_amount' => $faker->numberBetween(0, 4000),
        'amount_needed' => 5000,
    ];
});

$factory->define(App\Country::class, function (Faker\Generator $faker) {
   return [
       'ip_address' => $faker->ipv4,
       'country' => $faker->country,
       'remember_key' => str_random()
   ];
});