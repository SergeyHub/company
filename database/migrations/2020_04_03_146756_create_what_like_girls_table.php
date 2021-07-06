<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWhatLikeGirlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('what_like_girls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('what_like_id');
            $table->unsignedInteger('girl_id');
            $table->unique(['girl_id', 'what_like_id']);
            $table->foreign('what_like_id')
                ->references('id')
                ->on('what_likes')
                ->onDelete('cascade');
            $table->foreign('girl_id')
                ->references('id')
                ->on('girls')
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
        Schema::dropIfExists('what_like_girls');
    }
}
