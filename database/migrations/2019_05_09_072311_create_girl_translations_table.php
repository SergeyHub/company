<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGirlTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('girl_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('about')->nullable();
            $table->text('dating_imagine')->nullable();
            $table->unsignedInteger('girl_id');
            $table->string('locale')->index('locale_index');

            $table->unique(['girl_id', 'locale']);
            $table->foreign('girl_id')
                ->references('id')
                ->on('girls')
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
        Schema::dropIfExists('girl_translations');
    }
}
