<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEthnicitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ethnicities', function (Blueprint $table) {
            $table->increments('id');
        });

        Schema::create('ethnicity_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('ethnicity_id');
            $table->string('name');
            $table->string('locale')->index('locale_index');

            $table->unique(['ethnicity_id', 'locale']);
            $table->foreign('ethnicity_id')
                ->references('id')
                ->on('ethnicities')
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
        Schema::dropIfExists('ethnicity_translations');
        Schema::dropIfExists('ethnicities');
    }
}
