<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hairs', function (Blueprint $table) {
            $table->increments('id');
        });

        Schema::create('hair_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('hair_id');
            $table->string('name');
            $table->string('locale')->index('locale_index');

            $table->unique(['hair_id', 'locale']);
            $table->foreign('hair_id')
                ->references('id')
                ->on('hairs')
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
        Schema::dropIfExists('hair_translations');
        Schema::dropIfExists('hairs');
    }
}
