<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\TeacherStoreRequest;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{

    /*** Teacher dashboard ***/
    public function teacherDashboard()
    {
        return view('authTeacher.dashboard');
    }



    /*** get all Teachers ***/
    public function index()
    {
        $teachers = Teacher::latest()->paginate(page);
        return view('pages.teachers.index',compact('teachers'));
    }



    /*** create Teacher Page ***/
    public function create()
    {
        return view('pages.teachers.create');
    }



    /*** store Teacher ***/
    public function store(TeacherStoreRequest $request)
    {
        $teacher = Teacher::query()->create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
            'type'=> 2,
            'active'=> 1,
            'normal'=> $request->normal,
            'number_of_students'=> $request->number_of_students,
            'remain'=> $request->number_of_students,
        ]);

        return redirect()->route('get_all_teachers')->with('alert-success','تم حفظ البيانات بنجاح');
    }



    /*** forceDelete Teacher ***/
    public function forceDelete($id)
    {
        $teacher = Teacher::query()->findOrFail($id)->forceDelete();
        return redirect()->route('get_all_teachers')->with('alert-danger','تم حذف البيانات بنجاح');
    }



    /*** show Teacher ***/
    public function show($id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('pages.teachers.show',compact('teacher'));
    }



    /*** edit profile ***/
    public function editProfile()
    {
        $teacher = Teacher::findOrFail(Auth::guard('teacher')->id());
        return view('pages.teachers.edit_profile',compact('teacher'));
    }


    /*** update Teacher profile ***/
    public function updateProfile(Request $request)
    {
        $teacher = Teacher::findOrFail(Auth::guard('teacher')->id());

        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:teachers,email,'.$teacher->id,
        ],
        [
            'name.required'=>' الاسم مطلوب',
            'email.required'=>' البريد الإلكتروني مطلوب',
            'email.unique'=>'هذا البريد الالكتروني موجود بالفعل'
        ]
        );



        $teacher->name = $request->name;
        $teacher->email = $request->email;
        if ($request->password !== null)
        {
            $teacher->password = Hash::make($request->password);
        }
        $teacher->update();

        return redirect()->back()->with('alert-info','تم تحديث البيانات بنجاح');
    }




    /*** update Teacher system ***/
    public function updateSystem(Request $request)
    {
        $teacher = Teacher::findOrFail($request->teacher_id);

        $teacher->normal = $request->normal;

        if ($request->normal == 2)
        {
            $teacher->number_of_students = $request->number_of_students;
            $teacher->remain = $request->number_of_students;

        }else{
            $teacher->number_of_students = null;
        }

        $teacher->save();

        return redirect()->back()->with('alert-info','تم تحديث البيانات بنجاح');
    }




    /*** change Status of teacher ***/
    public function changeStatus($id)
    {
        $teacher = Teacher::query()->where('id',$id)->first();

        if ($teacher->active == 1)
        {
            $teacher->active = 2;
        }else{
            $teacher->active = 1;
        }
        $teacher->save();

        return redirect()->back()->with('alert-info','تم تحديث البيانات بنجاح');
    }



} //end of class
