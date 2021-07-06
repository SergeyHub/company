<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrientationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orientations', function (Blueprint $table) {
            $table->increments('id');
        });

        Schema::create('orientation_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('orientation_id');
            $table->string('name');
            $table->string('locale')->index('locale_index');

            $table->unique(['orientation_id', 'locale']);
            $table->foreign('orientation_id')
                ->references('id')
                ->on('orientations')
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
        Schema::dropIfExists('orientation_translations');
        Schema::dropIfExists('orientations');
    }
}
