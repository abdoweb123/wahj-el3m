<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /***  Run the migrations. ***/
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->boolean('active')->default(1); // 1-active  2-inactive
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('teacher_id')->references('id')->on('teachers')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }



    /***  Reverse the migrations. ***/
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
