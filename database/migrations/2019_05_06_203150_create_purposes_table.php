<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurposesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purposes', function (Blueprint $table) {
            $table->increments('id');
        });
        Schema::create('purpose_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('purpose_id');
            $table->string('name');
            $table->string('locale')->index('locale_index');

            $table->unique(['purpose_id', 'locale']);
            $table->foreign('purpose_id')
                ->references('id')
                ->on('purposes')
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
        Schema::dropIfExists('purpose_translations');
        Schema::dropIfExists('purposes');
    }
}
