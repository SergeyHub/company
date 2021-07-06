<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactMethodAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_method_agencies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('contact_method_id');
            $table->unsignedBigInteger('agency_id');
            $table->unique(['agency_id', 'contact_method_id']);
            $table->foreign('contact_method_id')
                ->references('id')
                ->on('contact_methods')
                ->onDelete('cascade');
            $table->foreign('agency_id')
                ->references('id')
                ->on('agencies')
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
        Schema::dropIfExists('contact_method_agencies');
    }
}
