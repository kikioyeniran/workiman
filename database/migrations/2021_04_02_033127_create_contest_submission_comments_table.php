<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContestSubmissionCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contest_submission_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contest_submission_id');
            $table->unsignedBigInteger('user_id');
            $table->string("content");
            $table->enum("content_type", ["file", "text", "image"])->default("text");
            $table->foreign('contest_submission_id')->references('id')->on('contest_submissions')->onDelete('cascade');
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
        Schema::dropIfExists('contest_submission_comments');
    }
}
