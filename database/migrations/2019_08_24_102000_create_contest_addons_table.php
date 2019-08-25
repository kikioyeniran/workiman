<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContestAddonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contest_addons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('contest_id');
            $table->unsignedBigInteger('addon_id');
            $table->longText('content')->nullable();
            $table->foreign('contest_id')->references('id')->on('contests')->onDelete('cascade');
            $table->foreign('addon_id')->references('id')->on('addons')->onDelete('cascade');
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
        Schema::dropIfExists('contest_addons');
    }
}
