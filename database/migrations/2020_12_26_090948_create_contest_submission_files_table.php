<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContestSubmissionFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contest_submission_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('contest_submission_id');
            $table->string("content");
            $table->foreign('contest_submission_id')->references('id')->on('contest_submissions')->onDelete('cascade');
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
        Schema::dropIfExists('contest_submission_filess');
    }
}
