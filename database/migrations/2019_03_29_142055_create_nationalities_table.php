<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNationalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nationalities', function (Blueprint $table) {
            $table->increments('id');
        });

        Schema::create('nationality_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('nationality_id');
            $table->string('name');
            $table->string('locale')->index('locale_index');

            $table->unique(['nationality_id', 'locale']);
            $table->foreign('nationality_id')
                ->references('id')
                ->on('nationalities')
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
        Schema::dropIfExists('nationalities_translations');
        Schema::dropIfExists('nationalities');
    }
}
