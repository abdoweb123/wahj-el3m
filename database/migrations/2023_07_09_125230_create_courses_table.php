<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /***  Run the migrations. ***/
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('teacher_id');
            $table->boolean('active')->default(1); // 1-active  2-inactive
            $table->boolean('download')->default(2); // 1-allow_download  2-dont_allow
            $table->date('end_date')->nullable();
            $table->longText('description')->nullable();
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('teacher_id')->references('id')->on('teachers')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }



    /***  Reverse the migrations. ***/
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
