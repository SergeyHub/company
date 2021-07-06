<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFieldsGirls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('girls', function (Blueprint $table) {
            $table->unsignedInteger('orientation_id')->nullable();
            $table->unsignedInteger('body_hair_id')->nullable();
            $table->unsignedInteger('body_id')->nullable();
            $table->unsignedInteger('ethnicity_id')->nullable();

            $table->foreign('orientation_id')
                ->references('id')
                ->on('orientations')
                ->onDelete('set null');
            $table->foreign('body_hair_id')
                ->references('id')
                ->on('body_hairs')
                ->onDelete('set null');
            $table->foreign('body_id')
                ->references('id')
                ->on('bodies')
                ->onDelete('set null');
            $table->foreign('ethnicity_id')
                ->references('id')
                ->on('ethnicities')
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
            $table->dropColumn('orientation_id');
            $table->dropColumn('body_hair_id');
            $table->dropColumn('body_id');
            $table->dropColumn('ethnicity_id');
        });
    }
}
