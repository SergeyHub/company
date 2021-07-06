<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactMethodGirlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_method_girls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('contact_method_id');
            $table->unsignedInteger('girl_id');
            $table->unique(['girl_id', 'contact_method_id']);
            $table->foreign('contact_method_id')
                ->references('id')
                ->on('contact_methods')
                ->onDelete('cascade');
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
        Schema::dropIfExists('contact_method_girls');
    }
}
