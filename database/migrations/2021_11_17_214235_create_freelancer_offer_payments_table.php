<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFreelancerOfferPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('freelancer_offer_payments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('payment_reference');
            $table->string('payment_method');
            $table->double('amount')->default(0);
            $table->boolean('paid')->default(false);
            $table->unsignedBigInteger('freelancer_offer_id');
            $table->foreign('freelancer_offer_id')->references('id')->on('freelancer_offers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('freelancer_offer_payments');
    }
}