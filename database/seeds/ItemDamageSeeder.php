<?php

use Illuminate\Database\Seeder;
use App\Models\ItemDamage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class ItemDamageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        ItemDamage::truncate();

        Schema::enableForeignKeyConstraints();

        ItemDamage::insert([
            [
                "id" => 1,
                "item_damage" => "ไม่มีตำหนิ",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "id" => 2,
                "item_damage" => "มีตำหนิ",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
        ]);
    }
}
