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

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => 'Roberto Bani',
        'email' => 'roberto.bani@gmail.com',
        'password' => '$2y$10$8EaPNv0NrhzS.huwUWKomewh02qCQg5Yj1wL3i8eMdr5NV7c2xdJa', // secret
        'remember_token' => str_random(10),
    ];
});
