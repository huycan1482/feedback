<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllTableSoftDeleteDropForeginKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedBigInteger('role_id');
            $table->tinyInteger('gender');
            $table->string('address');
            $table->date('date_of_birth');
            $table->string('code', 255);
            $table->string('phone', 255);
            $table->string('avatar', 255)->nullable();
            $table->tinyInteger('is_active');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('role_id')
                ->references('id')->on('roles')
                ->onDelete('cascade');
        });

        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('subjects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->string('slug', 255);
            $table->string('code', 255);
            $table->tinyInteger('is_active');
            $table->unsignedBigInteger('user_create')->nullable();
            $table->unsignedBigInteger('user_update')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->string('slug', 255);
            $table->string('code', 255);
            $table->unsignedBigInteger('subject_id');
            $table->integer('total_lesson');
            $table->tinyInteger('is_active');
            $table->unsignedBigInteger('user_create')->nullable();
            $table->unsignedBigInteger('user_update')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('subject_id')
                ->references('id')->on('subjects')
                ->onDelete('cascade');
        });

        Schema::create('classes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->string('code', 255);
            $table->string('slug', 255);
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('teacher_id');
            $table->integer('total_number');
            $table->tinyInteger('is_active');
            $table->unsignedBigInteger('user_create')->nullable();
            $table->unsignedBigInteger('user_update')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('course_id')
                ->references('id')->on('courses')
                ->onDelete('cascade');

            $table->foreign('teacher_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });

        Schema::create('user_class', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('class_id');
            $table->tinyInteger('is_active');
            $table->unsignedBigInteger('user_create')->nullable();
            $table->unsignedBigInteger('user_update')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('class_id')
                ->references('id')->on('classes')
                ->onDelete('cascade');
        });

        Schema::create('lessons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255)->nullable();
            $table->string('slug', 255)->nullable();
            $table->text('notice')->nullable();
            $table->dateTime('start_at');
            $table->integer('time_limit');
            $table->unsignedBigInteger('class_id');
            $table->tinyInteger('is_active');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('class_id')
            ->references('id')->on('classes')
            ->onDelete('cascade');
        });

        Schema::create('check_in', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('lesson_id');
            $table->tinyInteger('is_check');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('lesson_id')
                ->references('id')->on('lessons')
                ->onDelete('cascade');
        });

        Schema::create('feedbacks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->string('slug', 255);
            $table->string('code', 255);
            $table->tinyInteger('is_active');
            $table->unsignedBigInteger('user_create')->nullable();
            $table->unsignedBigInteger('user_update')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });

        Schema::create('questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 255);
            $table->string('content', 255);
            $table->string('slug', 255);
            $table->tinyInteger('is_active');
            $table->unsignedBigInteger('user_create')->nullable();
            $table->unsignedBigInteger('user_update')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('feedback_question', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('feedback_id');
            $table->integer('position')->nullable();
            $table->unsignedBigInteger('user_create')->nullable();
            $table->unsignedBigInteger('user_update')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('question_id')
                ->references('id')->on('questions')
                ->onDelete('cascade');

            $table->foreign('feedback_id')
                ->references('id')->on('feedbacks')
                ->onDelete('cascade');
        });

        
        Schema::create('answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('question_id');
            $table->string('code', 255);
            $table->text('content');
            $table->tinyInteger('type');
            $table->tinyInteger('is_true');
            $table->unsignedBigInteger('user_create')->nullable();
            $table->unsignedBigInteger('user_update')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('question_id')
                ->references('id')->on('questions')
                ->onDelete('cascade');
        });

        Schema::create('feedback_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('feedback_id');
            $table->unsignedBigInteger('class_id');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->unsignedBigInteger('user_create')->nullable();
            $table->unsignedBigInteger('user_update')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('feedback_id')
                ->references('id')->on('feedbacks')
                ->onDelete('cascade');

            $table->foreign('class_id')
                ->references('id')->on('classes')
                ->onDelete('cascade');
        });

        Schema::create('user_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('answer_id');
            $table->unsignedBigInteger('feedBackDetail_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('question_id')
                ->references('id')->on('questions')
                ->onDelete('cascade');

            $table->foreign('answer_id')
                ->references('id')->on('answers')
                ->onDelete('cascade');

            $table->foreign('feedBackDetail_id')
                ->references('id')->on('feedback_details')
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
        // Schema::dropIfExists('users');

        // Schema::disableForeignKeyConstraints();
        // Schema::drop('tableName');
        // Schema::enableForeignKeyConstraints();

        Schema::table('[table]', function (Blueprint $table) {
            $table->dropForeign('[table]_[column]_foreign');
            $table->dropColumn('[column]');
        });
    }
}
