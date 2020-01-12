<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Pawn;
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

$factory->define(Pawn::class, function (Faker $faker, $options) {
    $customer_role = Role::where('role', 'customer')->first();

    if (is_null($customer_role)) {
        $customer_role = Role::create(['role' => 'customer']);
    }

    return [
        'interest_rate' => $faker->randomFloat(2, 0, 20),
        'customer_id' => isset($options['customer_id']) ? $options['customer_id'] : factory(User::class)->create([
            'role_id' => $customer_role->id
        ])->id
    ];
});
