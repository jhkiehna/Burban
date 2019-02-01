<?php

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
        'city' => $faker->city(),
        'state' => $faker->stateAbbr(),
        'coordinates' => $faker->text(10),
        'phone' => $faker->text(10),
        'summary' => $faker->realText(200),
        'image' => $faker->text(10),
    ];
});
