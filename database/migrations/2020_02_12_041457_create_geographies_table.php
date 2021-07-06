<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeographiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geographies', function (Blueprint $table) {
            $table->increments('id');
        });
        Schema::create('geography_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('geography_id');
            $table->string('name');
            $table->string('locale')->index('locale_index');

            $table->unique(['geography_id', 'locale']);
            $table->foreign('geography_id')
                ->references('id')
                ->on('geographies')
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
        Schema::dropIfExists('geography_translations');
        Schema::dropIfExists('geographies');
    }
}
