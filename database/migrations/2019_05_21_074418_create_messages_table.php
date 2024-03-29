<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('dialog_id');
            $table->unsignedInteger('user_from_id');
            $table->unsignedInteger('user_to_id');
            $table->text('content')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('dialog_id')
                ->references('id')
                ->on('dialogs')
                ->onDelete('cascade');

            $table->foreign('user_from_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('user_to_id')
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
        Schema::dropIfExists('messages');
    }
}
