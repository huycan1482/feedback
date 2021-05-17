<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
            $table->string('avatar', 255);
            $table->tinyInteger('is_active');
            $table->rememberToken();
            $table->timestamps();

            // $table->foreign('role_id')
            //     ->references('id')->on('roles')
            //     ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
