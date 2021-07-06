<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToBlogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->unsignedInteger('views')->default(0);
            $table->softDeletes();
        });
        Schema::table('blog_translations', function (Blueprint $table) {
            $table->text('short_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('views');
            $table->dropColumn('deleted_at');
        });
        Schema::table('blog_translations', function (Blueprint $table) {
            $table->dropColumn('short_description');
        });
    }
}
