<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPawnIdToPawnItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pawn_items', function (Blueprint $table) {
            $table->unsignedBigInteger('pawn_id')->nullable();
            $table->foreign('pawn_id')
                  ->references('id')
                  ->on('pawns')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pawn_items', function (Blueprint $table) {
            //
        });
    }
}
