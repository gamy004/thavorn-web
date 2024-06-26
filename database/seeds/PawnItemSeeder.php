<?php

use Illuminate\Database\Seeder;
use App\Models\Pawn;
use App\Models\PawnItem;
use App\Models\ItemDamage;

class PawnItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        PawnItem::truncate();

        Schema::enableForeignKeyConstraints();

        $pawns = Pawn::select(['id'])->get();

        foreach($pawns as $pawn) {
            for($i = 0; $i < 2; $i++) {
                $mock_item_damage = $i % 2 === 0 ? 'ไม่มีตำหนิ' : 'มีตำหนิ';
                $item_damage = ItemDamage::where('item_damage', $mock_item_damage)->first();

                factory(PawnItem::class)->create([
                    'pawn_id' => $pawn->id,
                    'item_damage_id' => !is_null($item_damage) ? $item_damage->id : factory(ItemDamage::class)->create()->id
                ]);
            }
        }
    }
}
