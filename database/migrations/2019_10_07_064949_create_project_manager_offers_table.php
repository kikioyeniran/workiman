<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectManagerOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_manager_offers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('sub_category_id');
            $table->string('title');
            $table->longText('description');
            $table->tinyInteger('minimum_designer_level')->nullable();
            $table->double('budget');
            $table->string('delivery_mode');
            $table->unsignedBigInteger('offer_user_id')->nullable();
            $table->integer('timeline');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('offer_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('sub_category_id')->references('id')->on('offer_sub_categories')->onDelete('cascade');
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
        Schema::dropIfExists('offers');
    }
}
