<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    /*** get courses ***/
    public function index()
    {
        $courses = Course::query()->where('teacher_id',auth('teacher')->id())
            ->latest()->paginate(page);
        return view('pages.courses.index', compact('courses'));
    }



    /*** create Page ***/
    public function create()
    {
        return view('pages.courses.create');
    }



    /*** edit Page ***/
    public function edit(Course $course)
    {
        return view('pages.courses.edit',compact('course'));
    }



    /*** show Page ***/
    public function show(Course $course)
    {
        return view('pages.courses.show',compact('course'));
    }



    /*** store country ***/
    public function store(Request $request)
    {

        $request->validate([
            'name'=>'required',
            'end_date'=>'required',
        ],
            [
                'name.required'=>' الاسم مطلوب',
                'end_date.required'=>' تاريخ الانتهاء مطلوب',
            ]
        );


        $course = Course::query()->create([
            'name' => $request['name'],
            'active' => 1,
            'end_date' => $request['end_date'],
            'download' => $request['download'],
            'description' => $request['description'],
            'teacher_id' => auth('teacher')->id(),
        ]);

        return redirect()->route('courses.index')->with('alert-success','تم حفظ البيانات بنجاح');
    }




    /*** update country ***/
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name'=>'required',
            'end_date'=>'required',
        ],
            [
                'name.required'=>' الاسم مطلوب',
                 'end_date.required'=>' تاريخ الانتهاء مطلوب',
            ]
        );

        $course->name = $request->name;
        $course->end_date = $request->end_date;
        $course->download = $request->download;
        $course->description = $request->description;
        $course->save();
        return redirect()->route('courses.index')->with('alert-info','تم تعديل البيانات بنجاح');
    }




    /*** softDelete country ***/
    public function course(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('alert-danger','تم حذف البيانات بنجاح');
    }



    /*** change Status of course ***/
    public function changeStatus($id)
    {
        $course = Course::query()->where('id',$id)->first();

        if ($course->active == 1)
        {
            $course->active = 2;
        }else{
            $course->active = 1;
        }
        $course->save();

        return redirect()->back()->with('alert-info','تم تحديث البيانات بنجاح');
    }



    /*** delete course forever ***/
    public function forceDelete($id)
    {
        $course = Course::query()->findOrFail($id)->forceDelete();

        return redirect()->back()->with('alert-info','تم حذف البيانات بنجاح');
    }


} //end of class
