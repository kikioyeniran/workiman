<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectManagerOfferFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_manager_offer_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_manager_offer_id');
            $table->longText('content');
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
        Schema::dropIfExists('project_manager_offer_files');
    }
}
