<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReviewsTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('review')->nullable();
            $table->string('meeting_city')->nullable();
            $table->unsignedInteger('review_id');
            $table->string('locale')->index('locale_index');

            $table->unique(['review_id', 'locale']);
            $table->foreign('review_id')
                ->references('id')
                ->on('reviews')
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
        Schema::dropIfExists('review_translations');
    }
}
