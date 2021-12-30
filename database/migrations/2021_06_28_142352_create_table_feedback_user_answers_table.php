<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFeedbackUserAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('user_answers', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->unsignedBigInteger('user_id');
        //     $table->unsignedBigInteger('feedBackDetail_id');
        //     $table->text('opinion')->nullable();
        //     $table->tinyInteger('status');
        //     $table->timestamps();
        //     $table->softDeletes();

        //     $table->foreign('user_id')
        //         ->references('id')->on('users')
        //         ->onDelete('cascade');

        //     $table->foreign('feedBackDetail_id')
        //         ->references('id')->on('feedback_details')
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
        // Schema::dropIfExists('user_answers');
    }
}
