<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('active')->default('1');
            $table->timestamps();
        });

        Schema::create('faq_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('question');
            $table->longText('answer');

            $table->unsignedBigInteger('faq_id');

            $table->string('locale')->index('locale_index');

            $table->unique(['faq_id', 'locale']);
            $table->foreign('faq_id')
                ->references('id')
                ->on('faqs')
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
        Schema::dropIfExists('faq_translations');
        Schema::dropIfExists('faqs');
    }
}
