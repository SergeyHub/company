<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_from')->nullable();
            $table->unsignedInteger('user_to');
            $table->unsignedInteger('girl_id');
            $table->text('content');
            $table->datetime('meeting_date')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('recall')->default(false);
            $table->timestamps();

            $table->foreign('user_from')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('user_to')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('client_applications');
    }
}
