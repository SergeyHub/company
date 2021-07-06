<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWhatLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('what_likes', function (Blueprint $table) {
            $table->increments('id');
        });

        Schema::create('what_like_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('what_like_id');
            $table->string('name');
            $table->string('locale')->index('locale_index');

            $table->unique(['what_like_id', 'locale']);
            $table->foreign('what_like_id')
                ->references('id')
                ->on('what_likes')
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
        Schema::dropIfExists('what_like_translations');
        Schema::dropIfExists('what_likes');
    }
}
