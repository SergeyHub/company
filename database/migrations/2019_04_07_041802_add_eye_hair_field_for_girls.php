<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEyeHairFieldForGirls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('girls', function (Blueprint $table) {
            $table->unsignedInteger('eye_id')->nullable();
            $table->unsignedInteger('hair_id')->nullable();
            $table->foreign('eye_id')
                ->references('id')
                ->on('eyes')
                ->onDelete('set null');
            $table->foreign('hair_id')
                ->references('id')
                ->on('hairs')
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
        Schema::table('girls', function (Blueprint $table) {
            $table->dropColumn('eye_id');
            $table->dropColumn('hair_id');
        });
    }
}
