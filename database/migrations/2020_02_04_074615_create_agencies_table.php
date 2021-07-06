<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agencies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_image')->nullable();
            $table->string('status')->default('wait');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });


        Schema::create('agency_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedBigInteger('agency_id');
            $table->longText('description')->nullable();
            $table->string('locale')->index('locale_index');
            $table->unique(['agency_id', 'locale']);
            $table->foreign('agency_id')
                ->references('id')
                ->on('agencies')
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
        Schema::dropIfExists('agency_translations');
        Schema::dropIfExists('agencies');
    }
}
