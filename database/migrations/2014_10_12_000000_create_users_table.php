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
            $table->increments('id');
            $table->string('UserCode')->unique();
            $table->string('Username')->unique();
            $table->string('password');
            $table->string('Fullname')->nullable();
            $table->date('DateOfBirth')->nullable();
            $table->string('Sex')->nullable();
            $table->string('Email')->unique();
            $table->integer('Weight')->nullable();
            $table->string('Height')->nullable();
            $table->integer('TotalMatches')->nullable();
            $table->string('PhoneNumber')->nullable();
            $table->integer('City')->nullable();
            $table->string('Ward')->nullable();
            $table->string('Description')->nullable();
            $table->string('ImgUrl')->nullable();
            $table->string('MainPosition')->nullable();
            $table->string('ExtraPosition')->nullable();
            $table->string('DateCreated')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('status');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
