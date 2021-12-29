<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInterestIdToSumissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('freelancer_offer_submissions', function (Blueprint $table) {
            $table->unsignedBigInteger('interest_id');
            $table->foreign('interest_id')->references('id')->on('freelancer_offer_interests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('freelancer_offer_submissions', function (Blueprint $table) {
            $table->dropColumn('interest_id');
        });
    }
}