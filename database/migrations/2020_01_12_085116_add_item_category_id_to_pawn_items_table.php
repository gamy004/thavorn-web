<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddItemCategoryIdToPawnItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pawn_items', function (Blueprint $table) {
             $table->unsignedBigInteger('item_category_id')->nullable();
             $table->foreign('item_category_id')
                   ->references('id')
                   ->on('item_categories')
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
