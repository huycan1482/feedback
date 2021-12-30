<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFeedbackDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('feedback_details', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->unsignedBigInteger('feedback_id');
        //     $table->unsignedBigInteger('class_id');
        //     $table->tinyInteger('is_active');
        //     $table->dateTime('start_at');
        //     $table->dateTime('end_at');
        //     $table->unsignedBigInteger('user_create')->nullable();
        //     $table->unsignedBigInteger('user_update')->nullable();
        //     $table->timestamps();
        //     $table->softDeletes();

        //     $table->foreign('feedback_id')
        //         ->references('id')->on('feedbacks')
        //         ->onDelete('cascade');

        //     $table->foreign('class_id')
        //         ->references('id')->on('classes')
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
        // Schema::dropIfExists('feedback_details');
    }
}
