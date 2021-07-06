<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGirlCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('girl_costs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('girl_id');
            $table->unsignedInteger('currency_id');
            $table->string('duration');
            $table->unsignedInteger('amount');

            $table->unique(['girl_id', 'duration']);

            $table->foreign('girl_id')
                ->references('id')
                ->on('girls')
                ->onDelete('cascade');
            $table->foreign('currency_id')
                ->references('id')
                ->on('currencies')
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
        Schema::dropIfExists('girl_costs');
    }
}
