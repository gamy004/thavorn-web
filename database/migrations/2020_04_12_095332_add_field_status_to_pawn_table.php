<?php

use App\Models\Pawn;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldStatusToPawnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pawns', function (Blueprint $table) {
            $table->date('latest_paid_at')->nullable();
            $table->date('next_paid_at')->nullable();
            $table->boolean('complete')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pawns', function (Blueprint $table) {
            $table->dropColumn(['complete']);
            $table->dropColumn(['next_paid_at']);
            $table->dropColumn(['latest_paid_at']);
        });
    }
}
