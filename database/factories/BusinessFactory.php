<?php

use App\User;
use App\Business;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Business::class, function (Faker $faker) {
    return [
        'name' => $faker->company(),
        'user_id' => factory(User::class)->lazy(),
        'street_address' => $faker->streetAddress(),
        'city' => $faker->city(),
        'state' => $faker->stateAbbr(),
        'coordinates' => ['lat' => $faker->latitude(), 'lng' => $faker->longitude()],
        'phone' => $faker->phoneNumber(),
        'summary' => $faker->sentences(3, true),
        'image' => $faker->url(),
    ];
});
