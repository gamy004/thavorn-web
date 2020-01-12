<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

                Role::truncate();

                Schema::enableForeignKeyConstraints();

                Role::insert([
                    [
                        "id" => 1,
                        "role" => "admin",
                        "created_at" => Carbon::now(),
                        "updated_at" => Carbon::now()
                    ],
                    [
                        "id" => 2,
                        "role" => "customer",
                        "created_at" => Carbon::now(),
                        "updated_at" => Carbon::now()
                    ],
                ]);
    }
}
