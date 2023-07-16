<?php

namespace App\Http\Controllers;


use App\Http\Requests\StudentStoreRequest;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{

    /*** get students of teacher ***/
    public function index()
    {
        $teacher = Teacher::query()->findOrFail(auth('teacher')->id());
        $students = Student::query()->where('teacher_id',$teacher->id)->latest()->paginate(page);
        return view('pages.students.index',compact('students','teacher'));
    }



    /*** create student Page ***/
    public function create()
    {
        return view('pages.students.create');
    }



    /*** store student ***/
    public function store(StudentStoreRequest $request)
    {
        $teacher = Teacher::query()->findOrFail(auth('teacher')->id());
        if ($teacher->type !== 1){ // not supervisor
            if ($teacher->remain == 0){
                return redirect()->back()->withErrors(['msg'=>'لقد وصلت للحد الأقصى من الطلاب']);
            }
            else if ($teacher->remain == null){
                return redirect()->back()->withErrors(['msg'=>'غير مسموح لك بالتسجيل']);
            }
        }


        $student = Student::query()->create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
            'active'=> 1,
            'teacher_id'=> auth('teacher')->id(),
        ]);


        if ($teacher->type !== 1){
            $teacher->remain = $teacher->remain - 1;
            $teacher->save();
        }

        return redirect()->route('students_index')->with('alert-success','تم حفظ البيانات بنجاح');
    }



    /*** change Status of teacher ***/
    public function changeStatus($id)
    {
        $student = Student::query()->where('id',$id)->first();

        if ($student->active == 1)
        {
            $student->active = 2;
        }else{
            $student->active = 1;
        }
        $student->save();

        return redirect()->back()->with('alert-info','تم تحديث البيانات بنجاح');
    }



    /*** forceDelete student ***/
    public function forceDelete($id)
    {
        $student = Student::query()->findOrFail($id)->forceDelete();
        return redirect()->route('students_index')->with('alert-danger','تم حذف البيانات بنجاح');
    }


} //end of class
