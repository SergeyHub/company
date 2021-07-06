<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->text('review');
            $table->morphs('model');
            $table->string('nickname');
            $table->string('email');
            $table->date('meeting_date');
            $table->integer('duration');
            $table->boolean('published')->default(false);
            $table->string('meeting_city');
            $table->enum('duration_type', [
                App\Entity\Review\Review::HOURS, App\Entity\Review\Review::DAYS,
            ]);
            $table->integer('price');
            $table->unsignedInteger('currency_id');
            $table->unsignedInteger('country_id');
            $table->timestamps();
            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
                ->onDelete('cascade');
            $table->foreign('currency_id')
                ->references('id')
                ->on('currencies')
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
        Schema::dropIfExists('reviews');
    }
}
