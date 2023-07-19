<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\VideoHomework;
use Illuminate\Http\Request;

class VideoHomeworkController extends Controller
{

    /*** get homeworks ***/
    public function index($video_id)
    {
        $homework_video = VideoHomework::query()->where('teacher_id',auth('teacher')->id())
            ->where('video_id',$video_id)->latest()->paginate(page);

        $video = Video::query()->findOrFail($video_id);
        return view('pages.homework_video.index', compact('homework_video','video'));
    }



    /*** create Page ***/
    public function create($video_id)
    {
        $video = Video::query()->findOrFail($video_id);

        return view('pages.homework_video.create',compact('video'));
    }



    /*** store country ***/
    public function store(Request $request)
    {

        $request->validate([
            'content'=>'required',
        ],
            [
                'content.required'=>' الوصف مطلوب',
            ]
        );


        $homework_video = VideoHomework::query()->create([
            'name' => $request['name'],
            'content' => $request['content'],
            'teacher_id' => auth('teacher')->id(),
            'video_id' => $request->video_id,

        ]);

        return redirect()->route('videoHomework_video_index',$request->video_id)->with('alert-success','تم حفظ البيانات بنجاح');
    }




    /*** show Page ***/
    public function show($id)
    {
        $homework = VideoHomework::query()->findOrFail($id);
        return view('pages.homework_video.show',compact('homework'));
    }


    /*** edit Page ***/
    public function edit($id)
    {
        $homework = VideoHomework::query()->findOrFail($id);

        $video = Video::query()->findOrFail($homework->video_id);

        return view('pages.homework_video.edit',compact('homework','video'));
    }



    /*** update country ***/
    public function update(Request $request, $id)
    {
        $request->validate([
            'content'=>'required',
        ],
            [
                'content.required'=>' الوصف مطلوب',
            ]
        );
        $homework_video = VideoHomework::query()->findOrFail($id);

        $homework_video->name = $request->name;
        $homework_video->save();
        return redirect()->route('videoHomework_video_index',$homework_video->video_id)->with('alert-info','تم تعديل البيانات بنجاح');
    }








    /*** delete course forever ***/
    public function forceDelete($id)
    {
        $homework_video = VideoHomework::query()->findOrFail($id)->forceDelete();

        return redirect()->back()->with('alert-danger','تم حذف البيانات بنجاح');
    }


} //end of class
