<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReadyForGirlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ready_for_girls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('ready_for_id');
            $table->unsignedInteger('girl_id');
            $table->unique(['girl_id', 'ready_for_id']);
            $table->foreign('ready_for_id')
                ->references('id')
                ->on('ready_fors')
                ->onDelete('cascade');
            $table->foreign('girl_id')
                ->references('id')
                ->on('girls')
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
        Schema::dropIfExists('ready_for_girls');
    }
}
