<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntroVideosTable extends Migration
{
    /***  Run the migrations. ***/
    public function up()
    {
        Schema::create('intro_videos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('path');
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('course_id');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('teacher_id')->references('id')->on('teachers')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('course_id')->references('id')->on('courses')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }



    /***  Reverse the migrations. ***/
    public function down()
    {
        Schema::dropIfExists('intro_videos');
    }
}
