<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('lessons', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->string('name', 255)->nullable();
        //     $table->string('slug', 255)->nullable();
        //     $table->text('note')->nullable();
        //     $table->dateTime('start_at');
        //     $table->integer('time_limit');
        //     $table->unsignedBigInteger('class_id');
        //     $table->tinyInteger('is_active');
        //     $table->timestamps();
        //     $table->softDeletes();

        //     $table->foreign('class_id')
        //     ->references('id')->on('classes')
        //     ->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('lessons');
    }
}
