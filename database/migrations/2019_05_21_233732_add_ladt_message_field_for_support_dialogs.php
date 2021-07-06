<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLadtMessageFieldForSupportDialogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('support_dialogs', function (Blueprint $table) {
            $table->unsignedBigInteger('last_message_id')->nullable();

            $table->foreign('last_message_id')
                ->references('id')
                ->on('support_messages')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('support_dialogs', function (Blueprint $table) {
            $table->dropColumn('last_message_id');
        });
    }
}
