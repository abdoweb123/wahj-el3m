<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IntroVideo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['path', 'teacher_id','course_id',];



    /*** start relations ***/

    public function teacher()
    {
        return $this->belongsTo(Teacher::class,'teacher_id');
    }


    public function course()
    {
        return $this->belongsTo(Course::class,'course_id');
    }

    /*** end relations ***/


} //end of class
