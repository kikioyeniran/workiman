<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectManagerOfferPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_manager_offer_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_manager_offer_id');
            $table->string('payment_reference');
            $table->string('payment_method');
            $table->double('amount')->default(0);
            $table->boolean('paid')->default(0);
            $table->foreign('project_manager_offer_id')->references('id')->on('project_manager_offers')->onDelete('cascade');
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
        Schema::dropIfExists('project_manager_offer_payments');
    }
}