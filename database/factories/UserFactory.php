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

$factory->define(App\Model\User::class, function (Faker $faker) {
    return [
        'username' => $faker->unique()->username,
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => sha1("test"),
        'verifyHash' => $faker->sha1,
        'verified' => $faker->numberBetween(0,1),
        'joined' => $faker->date(),
    ];
});
