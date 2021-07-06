<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->increments('id');
        });
        Schema::create('language_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('language_id');
            $table->string('name');
            $table->string('locale')->index('locale_index');

            $table->unique(['language_id', 'locale']);
            $table->foreign('language_id')
                ->references('id')
                ->on('languages')
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
        Schema::dropIfExists('language_translations');
        Schema::dropIfExists('languages');
    }
}
