<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFeedbackUserAnswersDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userAnswer_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('userAnswer_id');
            $table->unsignedBigInteger('answer_id');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('userAnswer_id')
                ->references('id')->on('user_answers')
                ->onDelete('cascade');

            $table->foreign('answer_id')
                ->references('id')->on('answers')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('userAnswer_details');
    }
}
