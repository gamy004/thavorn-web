<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(RoleSeeder::class);
        // $this->call(ItemCategorySeeder::class);
        $this->call(ItemDamageSeeder::class);
        // $this->call(PawnSeeder::class);
        // $this->call(PawnItemSeeder::class);
        // $this->call(PaymentSeeder::class);
    }
}
