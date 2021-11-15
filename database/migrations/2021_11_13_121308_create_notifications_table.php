<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('read')->default(false);
            $table->string('message')->nullable();
            $table->unsignedBigInteger('project_manager_offer_id')->nullable();
            $table->foreign('project_manager_offer_id')->references('id')->on('project_manager_offers')->onDelete('cascade');
            $table->unsignedBigInteger('freelancer_offer_id')->nullable();
            $table->foreign('freelancer_offer_id')->references('id')->on('freelancer_offers')->onDelete('cascade');
            $table->unsignedBigInteger('contest_id')->nullable();
            $table->foreign('contest_id')->references('id')->on('contests')->onDelete('cascade');
            $table->unsignedBigInteger('freelancer_offer_dispute_id')->nullable();
            $table->foreign('freelancer_offer_dispute_id')->references('id')->on('freelancer_offer_disputes')->onDelete('cascade');
            $table->unsignedBigInteger('project_manager_offer_dispute_id')->nullable();
            $table->foreign('project_manager_offer_dispute_id')->references('id')->on('project_manager_offer_disputes')->onDelete('cascade');
            $table->unsignedBigInteger('contest_dispute_id')->nullable();
            $table->foreign('contest_dispute_id')->references('id')->on('contest_disputes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}