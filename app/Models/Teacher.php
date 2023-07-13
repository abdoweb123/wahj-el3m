<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends \Illuminate\Foundation\Auth\User
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'email', 'password', 'type', 'active', 'normal', 'number_of_students'];



    /*** start relations ***/

    public function courses()
    {
        return $this->hasMany(Course::class,'teacher_id');
    }


    public function videos()
    {
        return $this->hasMany(Video::class,'teacher_id');
    }



    /*** end relations ***/


} //end of class
