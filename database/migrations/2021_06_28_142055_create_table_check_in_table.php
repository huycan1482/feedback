<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCheckInTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('check_in', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->unsignedBigInteger('user_id');
        //     $table->unsignedBigInteger('lesson_id');
        //     $table->tinyInteger('is_check');
        //     $table->timestamps();
        //     $table->softDeletes();

        //     $table->foreign('user_id')
        //         ->references('id')->on('users')
        //         ->onDelete('cascade');

        //     $table->foreign('lesson_id')
        //         ->references('id')->on('lessons')
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
        // Schema::dropIfExists('check_in');
    }
}
