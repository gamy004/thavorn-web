<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

                User::truncate();

                Schema::enableForeignKeyConstraints();

                factory(User::class)->create([
                    'email' => 'admin@admin.com',
					'role_id' => Role::where('role', 'admin')->first()->id
                ]);
    }
}
