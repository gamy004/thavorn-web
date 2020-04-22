<?php

use App\IOCs\DBCol;
use App\Models\Pawn;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        Pawn::with('pawn_items')->each(function ($pawn) use ($faker) {
            $rand_num_payment = $faker->numberBetween(1, 5);
            
            for ($i=1; $i <= $rand_num_payment; $i++) { 
                $rand_num_month = $faker->numberBetween(1, 12);
                $paid_amount = $pawn->computePaidAmount($rand_num_month);

                $pawn->pay($paid_amount, $rand_num_month);
            }
        });
    }
}
