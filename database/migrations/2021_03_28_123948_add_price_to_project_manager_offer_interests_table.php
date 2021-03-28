<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceToProjectManagerOfferInterestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_manager_offer_interests', function (Blueprint $table) {
            $table->double('price')->after('user_id')->default(0);
            $table->double('timeline')->after('price')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_manager_offer_interests', function (Blueprint $table) {
            //
        });
    }
}
