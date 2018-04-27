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
    static $password;

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'username' => $faker->unique()->username,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Client::class, function (Faker $faker) {
    $company = $faker->unique()->company;

    return [
        'slug' => strtolower(str_slug($company, '-')),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'user_created' => function() {
            return factory(App\User::class)->create()->id;
        },
        'company' => $company,
        'contact_number' => $faker->phonenumber,
        'building_number' => $faker->buildingnumber,
        'city' => $faker->city,
        'postcode' => $faker->postcode,
        'email' => $faker->unique()->safeEmail,
        'street_name' => $faker->StreetAddress,
    ];
});

$factory->define(App\Log::class, function (Faker $faker) {
    $title = $faker->name;

    return [
        'client_id' => function() {

            return factory(App\Client::class)->create()->id;
        },
        'user_created' => function() {

            return factory(App\User::class)->create()->id;
        },
        'slug' => strtolower(str_slug($title, '-')),
        'title' => $title,
        'description' => $faker->paragraph,
        'body' => $faker->paragraph,
        'notes' => $faker->paragraph,
    ];
});
