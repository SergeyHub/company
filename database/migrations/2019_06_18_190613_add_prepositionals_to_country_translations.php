<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrepositionalsToCountryTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('country_translations', function (Blueprint $table) {
            $table->string('name_genitive')->nullable();
            $table->string('name_prepositional')->nullable();
        });
        Schema::table('city_translations', function (Blueprint $table) {
            $table->string('name_genitive')->nullable();
            $table->string('name_prepositional')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('country_translations', function (Blueprint $table) {
            $table->dropColumn('name_genitive');
            $table->dropColumn('name_prepositional');
        });
        Schema::table('city_translations', function (Blueprint $table) {
            $table->dropColumn('name_genitive');
            $table->dropColumn('name_prepositional');
        });
    }
}
