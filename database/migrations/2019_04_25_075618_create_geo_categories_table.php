<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeoCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geo_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->double('girl_publication_cost')->nullable();
            $table->double('girl_phone_cost')->nullable();
        });
        Schema::create('geo_category_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('geo_category_id');
            $table->string('name');
            $table->string('locale')->index('locale_index');

            $table->unique(['geo_category_id', 'locale']);
            $table->foreign('geo_category_id')
                ->references('id')
                ->on('geo_categories')
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
        Schema::dropIfExists('geo_category_translations');
        Schema::dropIfExists('geo_categories');
    }
}
