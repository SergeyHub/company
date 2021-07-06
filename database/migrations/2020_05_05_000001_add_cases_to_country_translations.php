<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCasesToCountryTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('country_translations', function (Blueprint $table) {
            $table->string('name_instrumental')->nullable();
            $table->string('name_accusative')->nullable();
            $table->string('name_dative')->nullable();
        });
        Schema::table('city_translations', function (Blueprint $table) {
            $table->string('name_instrumental')->nullable();
            $table->string('name_accusative')->nullable();
            $table->string('name_dative')->nullable();
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
            $table->dropColumn('name_instrumental');
            $table->dropColumn('name_accusative');
            $table->dropColumn('name_dative');
        });
        Schema::table('city_translations', function (Blueprint $table) {
            $table->dropColumn('name_instrumental');
            $table->dropColumn('name_accusative');
            $table->dropColumn('name_dative');
        });
    }
}
