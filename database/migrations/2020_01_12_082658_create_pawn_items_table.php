<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreatePawnItemsTable extends Migration
{
    use SoftDeletes;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pawn_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('item_weight', 8, 2);
            $table->string('item_weight_unit')->default('gram');
            $table->decimal('item_value', 8, 2);
            $table->string('item_value_unit')->default('THB');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pawn_items');
    }
}
