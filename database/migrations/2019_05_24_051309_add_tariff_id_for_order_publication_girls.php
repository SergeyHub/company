<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTariffIdForOrderPublicationGirls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_girl_publications', function (Blueprint $table) {
            $table->unsignedInteger('tariff_id')->nullable();
            $table->foreign('tariff_id')
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
        Schema::table('order_girl_publications', function (Blueprint $table) {
            $table->dropColumn('tariff_id');
        });
    }
}
