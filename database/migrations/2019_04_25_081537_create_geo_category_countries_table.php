<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeoCategoryCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geo_category_country', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('geo_category_id');
            $table->unsignedInteger('country_id');
            $table->unique( 'country_id');
            $table->foreign('geo_category_id')
                ->references('id')
                ->on('geo_categories')
                ->onDelete('cascade');
            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
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
        Schema::dropIfExists('geo_category_countries');
    }
}
