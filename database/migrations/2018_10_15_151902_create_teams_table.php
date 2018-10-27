<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->increments('id');
            $table->string('TeamCode');
            $table->string('Fullname');
            $table->string('ImgUrl');
            $table->integer('WinRate');
            $table->integer('TotalScore');
            $table->integer('TotalMatch');
            $table->integer('TotalWin');
            $table->integer('TotalGoal');
            $table->string('Ward');
            $table->integer('City');
            $table->text('Description');
            $table->integer('Status');
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
        Schema::dropIfExists('teams');
    }
}
