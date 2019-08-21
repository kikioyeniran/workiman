<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContestCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contest_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->timestamps();
        });

        Schema::create('contest_sub_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->double('base_amount')->default(0);
            $table->unsignedBigInteger('contest_category_id');
            $table->foreign('contest_category_id')->references('id')->on('contest_categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contest_sub_categories');
        Schema::dropIfExists('contest_categories');
    }
}
