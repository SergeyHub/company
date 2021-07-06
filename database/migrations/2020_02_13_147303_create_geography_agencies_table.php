<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeographyAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geography_agencies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('geography_id');
            $table->unsignedBigInteger('agency_id');
            $table->unique(['agency_id', 'geography_id']);
            $table->foreign('geography_id')
                ->references('id')
                ->on('geographies')
                ->onDelete('cascade');
            $table->foreign('agency_id')
                ->references('id')
                ->on('agencies')
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
        Schema::dropIfExists('geography_agencies');
    }
}
