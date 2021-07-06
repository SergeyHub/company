<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('amount');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('currency_id')->nullable();
            $table->morphs('order');
            $table->string('status')->default('active');
            $table->timestamp('payed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('currency_id')
                ->references('id')
                ->on('currencies')
                ->onDelete('set null');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('bills');
    }
}
