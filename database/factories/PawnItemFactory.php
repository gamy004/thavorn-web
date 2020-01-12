<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\PawnItem;
use App\Models\Pawn;
use App\Models\ItemCategory;
use App\Models\ItemDamage;
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

$factory->define(PawnItem::class, function (Faker $faker, $options) {
    return [
        'item_weight' => $faker->randomFloat(2, 100, 1000),
        'item_weight_unit' => 'gram',
        'item_value' => $faker->randomFloat(2, 10000, 40000),
        'item_value_unit' => 'THB',
        'pawn_id' => isset($options['pawn_id']) ? $options['pawn_id'] : factory(Pawn::class)->create()->id,
        'item_category_id' => isset($options['item_category_id']) ? $options['item_category_id'] : factory(ItemCategory::class)->create()->id,
        'item_damage_id' => isset($options['item_damage_id']) ? $options['item_damage_id'] : factory(ItemDamage::class)->create()->id
    ];
});
