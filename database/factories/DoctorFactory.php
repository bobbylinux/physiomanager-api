<?php

use App\Models\Doctor;
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

$factory->define(Doctor::class, function (Faker $faker) {

    return [
        'last_name' => $faker->lastName,
        'first_name' => $faker->firstName,
        'enabled' => true,
        'created_at' => now(),
    ];
});
