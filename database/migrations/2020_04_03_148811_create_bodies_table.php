<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBodiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bodies', function (Blueprint $table) {
            $table->increments('id');
        });

        Schema::create('body_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('body_id');
            $table->string('name');
            $table->string('locale')->index('locale_index');

            $table->unique(['body_id', 'locale']);
            $table->foreign('body_id')
                ->references('id')
                ->on('bodies')
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
        Schema::dropIfExists('body_translations');
        Schema::dropIfExists('bodies');
    }
}
