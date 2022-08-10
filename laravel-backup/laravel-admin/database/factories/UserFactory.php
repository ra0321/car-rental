<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(User::class, function (Faker $faker) {
    return [
        'first_name' => $faker->name,
		'last_name' => $faker->name,
		'phone_number' => $faker->phoneNumber,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // password
        'currency_type' => random_int(3, 4),
        'country_code' => Str::random(5),
        'phone_number' => $faker->phoneNumber,
        'email_verified' => (bool)random_int(0, 1),
        'phone_verified' => (bool)random_int(0, 1),
        'approved_to_drive' => (bool)random_int(0, 1),
        'id_verified' => (bool)random_int(0, 1),
    ];
});
