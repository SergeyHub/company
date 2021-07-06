<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicationTariffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publication_tariffs', function (Blueprint $table) {
            $table->increments('id');
            $table->double('cost');
            $table->unsignedInteger('days');
            $table->softDeletes();
        });
        Schema::create('publication_tariff_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedInteger('publication_tariff_id');
            $table->string('locale')->index('locale_index');

            $table->unique(['publication_tariff_id', 'locale'], 'publication_trans_locale');
            $table->foreign('publication_tariff_id')
                ->references('id')
                ->on('publication_tariffs')
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
        Schema::dropIfExists('publication_tariff_translations');
        Schema::dropIfExists('publication_tariffs');
    }
}
