<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVipTariffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vip_tariffs', function (Blueprint $table) {
            $table->increments('id');
            $table->double('month_cost');
            $table->double('year_cost');

            $table->softDeletes();
        });
        Schema::create('vip_tariff_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedInteger('vip_tariff_id');
            $table->string('locale')->index('locale_index');

            $table->unique(['vip_tariff_id', 'locale'], 'vip_trans_locale');
            $table->foreign('vip_tariff_id')
                ->references('id')
                ->on('vip_tariffs')
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
        Schema::dropIfExists('vip_tariffs');
        Schema::dropIfExists('vip_tariff_translations');
    }
}
