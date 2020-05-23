<?php

use Illuminate\Database\Seeder;
use App\Models\Pawn;
use App\Models\User;

class PawnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        Pawn::truncate();

        Schema::enableForeignKeyConstraints();

        $customer = factory(User::class)->create();

        for($i = 0; $i < 100; $i++) {
            factory(Pawn::class)->create(['customer_id' => $customer->id]);
        }
    }
}
