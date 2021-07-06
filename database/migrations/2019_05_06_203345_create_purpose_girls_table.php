<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurposeGirlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purpose_girls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('purpose_id');
            $table->unsignedInteger('girl_id');
            $table->unique(['girl_id', 'purpose_id']);
            $table->foreign('purpose_id')
                ->references('id')
                ->on('purposes')
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
        Schema::dropIfExists('purpose_girls');
    }
}
