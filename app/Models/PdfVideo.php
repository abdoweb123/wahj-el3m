<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PdfVideo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'path', 'teacher_id', 'video_id', 'active',];



    /*** start relations ***/

    public function teacher()
    {
        return $this->belongsTo(Teacher::class,'teacher_id');
    }


    public function video()
    {
        return $this->belongsTo(Video::class,'video_id');
    }

    /*** end relations ***/


} //end of class
