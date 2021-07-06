<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeReviewsFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reviews', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->dropColumn('review');
            $table->dropColumn('meeting_city');
            $table->dropForeign('reviews_currency_id_foreign');
            $table->dropForeign('reviews_country_id_foreign');
            $table->dropColumn('meeting_date');
            $table->dropColumn('duration');
            $table->dropColumn('duration_type');
            $table->dropColumn('price');
            $table->dropColumn('currency_id');
            $table->dropColumn('country_id');
            Schema::enableForeignKeyConstraints();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->text('review');
            $table->string('meeting_city');
        });
    }
}
