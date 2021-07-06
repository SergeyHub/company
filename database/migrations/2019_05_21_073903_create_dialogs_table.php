<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDialogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dialogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_first');
            $table->unsignedInteger('user_second');
            $table->timestamp('last_message_time')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['user_first', 'user_second']);

            $table->foreign('user_first')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('user_second')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('dialogs');
    }
}
