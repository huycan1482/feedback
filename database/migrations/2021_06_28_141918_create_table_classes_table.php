<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        // Schema::create('classes', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->string('name', 255);
        //     $table->string('code', 255);
        //     $table->string('slug', 255);
        //     $table->unsignedBigInteger('course_id');
        //     $table->unsignedBigInteger('teacher_id');
        //     $table->integer('total_number');
        //     $table->tinyInteger('is_active');
        //     $table->unsignedBigInteger('user_create')->nullable();
        //     $table->unsignedBigInteger('user_update')->nullable();
        //     $table->timestamps();
        //     $table->softDeletes();

        //     $table->foreign('course_id')
        //         ->references('id')->on('courses')
        //         ->onDelete('cascade');

        //     $table->foreign('teacher_id')
        //         ->references('id')->on('users')
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
        // Schema::dropIfExists('classes');
    }
}
