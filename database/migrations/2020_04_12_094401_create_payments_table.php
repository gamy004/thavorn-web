<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    use SoftDeletes;
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('amount', 8, 2);
            $table->integer('month_amount')->comment('a number of month that paid for this record');
            $table->date('time_start_at')->comment('a start time of this payment (match with the payment cycle)');
            $table->date('time_end_at')->comment('an end time of this payment (match with the payment cycle)');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('payments', function (Blueprint $table) {
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
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['pawn_id']);
        });

        Schema::dropIfExists('payments');
    }
}
