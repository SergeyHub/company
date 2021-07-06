<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeographyGirlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geography_girls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('geography_id');
            $table->unsignedInteger('girl_id');
            $table->unique(['girl_id', 'geography_id']);
            $table->foreign('geography_id')
                ->references('id')
                ->on('geographies')
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
        Schema::dropIfExists('geography_girls');
    }
}
