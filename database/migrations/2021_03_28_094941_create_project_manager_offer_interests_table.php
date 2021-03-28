<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectManagerOfferInterestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_manager_offer_interests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_manager_offer_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('project_manager_offer_id')->references('id')->on('project_manager_offers')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('project_manager_offer_interests');
    }
}
