<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGirlMeetingPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('girl_meeting_points', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('girl_id');
            $table->string('type');
            $table->string('place');
            $table->unique(['type', 'place', 'girl_id']);
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
        Schema::dropIfExists('girl_meeting_points');
    }
}
