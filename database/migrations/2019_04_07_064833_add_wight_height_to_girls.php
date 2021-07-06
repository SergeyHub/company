<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWightHeightToGirls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('girls', function (Blueprint $table) {
            $table->unsignedInteger('weight')->nullable();
            $table->unsignedInteger('height')->nullable();
            $table->unsignedInteger('bust')->nullable();
            $table->unsignedInteger('waist')->nullable();
            $table->unsignedInteger('hip')->nullable();
            $table->string('favourite_drink')->nullable();
            $table->string('music')->nullable();
            $table->string('hobbies')->nullable();
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
            $table->dropColumn('weight');
            $table->dropColumn('height');
            $table->dropColumn('bust');
            $table->dropColumn('waist');
            $table->dropColumn('hip');
            $table->dropColumn('favourite_drink');
            $table->dropColumn('music');
            $table->dropColumn('hobbies');
        });
    }
}
