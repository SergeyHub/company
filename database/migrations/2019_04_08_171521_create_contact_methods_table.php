<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_methods', function (Blueprint $table) {
            $table->increments('id');
        });
        Schema::create('contact_method_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('contact_method_id');
            $table->string('name');
            $table->string('locale')->index('locale_index');

            $table->unique(['contact_method_id', 'locale']);
            $table->foreign('contact_method_id')
                ->references('id')
                ->on('contact_methods')
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
        Schema::dropIfExists('contact_method_translations');
        Schema::dropIfExists('contact_methods');
    }
}
