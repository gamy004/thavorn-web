<?php

use Illuminate\Database\Seeder;
use App\Models\ItemCategory;
use Illuminate\Support\Facades\Schema;

class ItemCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        ItemCategory::truncate();

        Schema::enableForeignKeyConstraints();

        for($i = 0; $i < 10; $i++) {
            factory(ItemCategory::class)->create();
        }
    }
}
