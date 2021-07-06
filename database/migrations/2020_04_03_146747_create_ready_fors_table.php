<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReadyForsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ready_fors', function (Blueprint $table) {
            $table->increments('id');
        });

        Schema::create('ready_for_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('ready_for_id');
            $table->string('name');
            $table->string('locale')->index('locale_index');

            $table->unique(['ready_for_id', 'locale']);
            $table->foreign('ready_for_id')
                ->references('id')
                ->on('ready_fors')
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
        Schema::dropIfExists('ready_for_translations');
        Schema::dropIfExists('ready_fors');
    }
}
