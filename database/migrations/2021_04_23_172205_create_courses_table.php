<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('courses', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->string('name', 255);
        //     $table->string('slug', 255);
        //     $table->string('code', 255);
        //     $table->unsignedBigInteger('subject_id');
        //     $table->integer('total_lesson');
        //     $table->tinyInteger('is_active');
        //     $table->unsignedBigInteger('user_create')->nullable();
        //     $table->unsignedBigInteger('user_update')->nullable();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
