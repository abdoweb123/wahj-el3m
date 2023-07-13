<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\PdfCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class PdfCourseController extends Controller
{
    /*** get videos ***/
    public function index($course_id)
    {
        $pdfs_course = PdfCourse::query()->where('teacher_id',auth('teacher')->id())
            ->where('course_id',$course_id)->latest()->paginate(page);

        $course = Course::query()->findOrFail($course_id);

        return view('pages.pdfs_course.index', compact('pdfs_course','course'));
    }



    /*** create video ***/
    public function create($course_id)
    {
        $course = Course::query()->findOrFail($course_id);

        return view('pages.pdfs_course.create', compact('course'));
    }



    /*** store country ***/
    public function store(Request $request)
    {
        $data = $request->all();

        $request->validate([
            'pdf'=>'required',
        ],
            [
                'pdf.required'=>'برجاء رفع الملف',
            ]
        );


        $pdfs_course = PdfCourse::query()->create([
            'name' => $request->name,
            'active' => 1,
            'path' => $data['pdf'],
            'teacher_id' => auth('teacher')->id(),
            'course_id' => $request->course_id,
        ]);

        return redirect()->route('pdfs_course_index',$request->course_id)->with('alert-success','تم تحميل الفيديو بنجاح');
    }




    /*** show video ***/
    public function show($pdf_id)
    {
        $pdfs_course = PdfCourse::query()->findOrFail($pdf_id);

        return response()->file(storage_path('/app/public/videos/'.$pdfs_course->path));
    }



    /*** forceDelete country ***/
    public function forceDelete($id)
    {
        $pdfs_course = PdfCourse::query()->findOrFail($id);

        // delete from folder
        unlink(storage_path('/app/public/videos/'.$pdfs_course->path));

        $pdfs_course->forceDelete();
        return redirect()->back()->with('alert-danger','تم حذف البيانات بنجاح');
    }



    /*** change Status of video ***/
    public function changeStatus($id)
    {
        $pdfs_course = PdfCourse::query()->where('id',$id)->first();

        if ($pdfs_course->active == 1)
        {
            $pdfs_course->active = 2;
        }else{
            $pdfs_course->active = 1;
        }
        $pdfs_course->save();

        return redirect()->back()->with('alert-info','تم تحديث البيانات بنجاح');
    }








    /*** upload video ***/
    public function uploadLargeFiles(Request $request) {
        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

        if (!$receiver->isUploaded()) {
            // file not uploaded
        }

        $fileReceived = $receiver->receive(); // receive file
        if ($fileReceived->isFinished()) { // file uploading is complete / all chunks are uploaded
            $file = $fileReceived->getFile(); // get file
            $extension = $file->getClientOriginalExtension();
            $fileName = str_replace('.'.$extension, '', $file->getClientOriginalName()); //file name without extenstion
            $fileName .= '_' . md5(time()) . '.' . $extension; // a unique file name

            $disk = Storage::disk(config('filesystems.default'));
            $path = $disk->putFileAs('public/videos', $file, $fileName);

            // delete chunked file
            unlink($file->getPathname());
            return [
                'path' => asset('storage/' . $path),
                'filename' => $fileName
            ];
        }

        // otherwise return percentage informatoin
        $handler = $fileReceived->handler();
        return [
            'done' => $handler->getPercentageDone(),
            'status' => true,
        ];
    }








} //end of class
