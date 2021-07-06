<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEyesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eyes', function (Blueprint $table) {
            $table->increments('id');
        });

        Schema::create('eye_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('eye_id');
            $table->string('name');
            $table->string('locale')->index('locale_index');

            $table->unique(['eye_id', 'locale']);
            $table->foreign('eye_id')
                ->references('id')
                ->on('eyes')
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
        Schema::dropIfExists('eye_translations');
        Schema::dropIfExists('eyes');
    }
}
