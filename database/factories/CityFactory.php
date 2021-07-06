<?php

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

$factory->define(\App\Entity\Geo\City\City::class, function (Faker $faker) {
    return [
        'slug' => $faker->slug,
        'ru' => [
            'name' => $faker->unique()->city,
        ],
        'en' => [
            'name' => $faker->unique()->city,
        ],
    ];
});
