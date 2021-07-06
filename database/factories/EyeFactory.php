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

$factory->define(\App\Entity\Options\Eye\Eye::class, function (Faker $faker) {
    return [
        'ru' => [
            'name' => $faker->unique()->colorName,
        ],
        'en' => [
            'name' => $faker->unique()->colorName,
        ],
    ];
});
