<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Role;
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

$factory->define(User::class, function (Faker $faker, $options) {
    $title = $faker->title;
    $gender_param = $title === 'Mr.' ? 'male' : 'female';
    $gender = $gender_param === 'male' ? 'M' : 'F';

    return [
        'first_name' => $faker->unique()->firstName($gender_param),
        'last_name' => $faker->unique()->lastName($gender_param),
        'email' => $faker->unique()->safeEmail,
        'identity_card_id' => Str::random(13),
        'phone_number' => Str::random(10),
        'gender' => $gender,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'role_id' => isset($options['role_id']) ? $options['role_id'] : factory(Role::class)->create()->id
    ];
});

$factory->state(User::class, 'customer', [
    'role_id' => Role::firstOrCreate(['role' => 'customer'])->id
]);

$factory->state(User::class, 'admin', [
    'role_id' => Role::firstOrCreate(['role' => 'admin'])->id
]);
