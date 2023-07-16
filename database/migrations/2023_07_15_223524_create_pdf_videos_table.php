<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePdfVideosTable extends Migration
{
     /***  Run the migrations. ***/
    public function up()
    {
        Schema::create('pdf_videos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('path');
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('video_id');
            $table->boolean('active')->default(1); // 1-active  2-inactive
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('teacher_id')->references('id')->on('teachers')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('video_id')->references('id')->on('videos')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }



    /***  Reverse the migrations. ***/
    public function down()
    {
        Schema::dropIfExists('pdf_videos');
    }
}
