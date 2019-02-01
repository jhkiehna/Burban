<?php

use App\Deal;
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

$factory->define(Deal::class, function (Faker $faker) {
    return [
        'business_id' => factory(Business::class)->lazy(),
        'title' => $faker->sentence(2),
        'description' => $faker->sentence(6),
    ];
});
