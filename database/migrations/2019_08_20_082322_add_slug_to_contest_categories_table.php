<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSlugToContestCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contest_categories', function (Blueprint $table) {
            $table->string('slug')->after('title')->unique();
        });

        Schema::table('contest_sub_categories', function (Blueprint $table) {
            $table->string('slug')->after('title')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contest_categories', function (Blueprint $table) {
            //
        });
    }
}
