<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('feedback_id');
            $table->unsignedBigInteger('class_id');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->unsignedBigInteger('user_create')->nullable();
            $table->unsignedBigInteger('user_update')->nullable();
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
        Schema::dropIfExists('feedback_details');
    }
}
