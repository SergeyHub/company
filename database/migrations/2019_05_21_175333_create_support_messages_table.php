<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupportMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('dialog_id');
            $table->unsignedInteger('user_id');
            $table->boolean('from_admin')->default(false);
            $table->boolean('read')->default(false);
            $table->text('content')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('dialog_id')
                ->references('id')
                ->on('support_dialogs')
                ->onDelete('cascade');

            $table->foreign('user_id')
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
        Schema::dropIfExists('support_messages');
    }
}
