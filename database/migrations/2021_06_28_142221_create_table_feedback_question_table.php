<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFeedbackQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('feedback_question', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->unsignedBigInteger('question_id');
        //     $table->unsignedBigInteger('feedback_id');
        //     $table->integer('position')->nullable();
        //     $table->unsignedBigInteger('user_create')->nullable();
        //     $table->unsignedBigInteger('user_update')->nullable();
        //     $table->timestamps();
        //     $table->softDeletes();

        //     $table->foreign('question_id')
        //         ->references('id')->on('questions')
        //         ->onDelete('cascade');

        //     $table->foreign('feedback_id')
        //         ->references('id')->on('feedbacks')
        //         ->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('feedback_question');
    }
}
