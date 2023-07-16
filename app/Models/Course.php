<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'teacher_id', 'active', 'end_date', 'download', 'description',];



    /*** start relations ***/

    public function teacher()
    {
        return $this->belongsTo(Teacher::class,'teacher_id');
    }


    public function videos()
    {
        return $this->hasMany(Video::class,'course_id');
    }



    public function introVideo()
    {
        return $this->hasOne(IntroVideo::class,'course_id');
    }


    public function pdfs()
    {
        return $this->hasMany(PdfCourse::class,'course_id');
    }



    public function students()
    {
        return $this->belongsToMany(Student::class,'student_courses','course_id','student_id');
    }

    /*** end relations ***/


} //end of class
