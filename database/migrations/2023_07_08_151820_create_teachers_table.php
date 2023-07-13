<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    /***  Run the migrations.  ***/
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->boolean('type'); // 1-supervisor  2-teacher
            $table->boolean('active')->default(1); // 1-active  2-inactive
            $table->boolean('normal')->nullable(); // 1-normal  2-number_of_students
            $table->integer('number_of_students')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }


    /***  Reverse the migrations.  ***/
    public function down()
    {
        Schema::dropIfExists('teachers');
    }
}
