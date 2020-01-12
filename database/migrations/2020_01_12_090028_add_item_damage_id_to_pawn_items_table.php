<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddItemDamageIdToPawnItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pawn_items', function (Blueprint $table) {
            $table->unsignedBigInteger('item_damage_id');
                         $table->foreign('item_damage_id')
                               ->references('id')
                               ->on('item_damages')
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
