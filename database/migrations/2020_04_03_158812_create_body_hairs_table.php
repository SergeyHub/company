<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBodyHairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('body_hairs', function (Blueprint $table) {
            $table->increments('id');
        });

        Schema::create('body_hair_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('body_hair_id');
            $table->string('name');
            $table->string('locale')->index('locale_index');

            $table->unique(['body_hair_id', 'locale']);
            $table->foreign('body_hair_id')
                ->references('id')
                ->on('body_hairs')
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
        Schema::dropIfExists('body_hair_translations');
        Schema::dropIfExists('body_hairs');
    }
}
