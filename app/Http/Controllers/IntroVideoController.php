<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\IntroVideo;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class IntroVideoController extends Controller
{

    /*** get intro_video ***/
    public function index($course_id)
    {
        $intro_video = IntroVideo::query()->where('teacher_id',auth('teacher')->id())
            ->where('course_id',$course_id)->latest()->paginate(page);

        $course = Course::query()->findOrFail($course_id);

        return view('pages.intro_videos.index', compact('intro_video','course'));
    }



    /*** create video ***/
    public function create($course_id)
    {
        $course = Course::query()->findOrFail($course_id);

        return view('pages.intro_videos.create', compact('course'));
    }



    /*** store country ***/
    public function store(Request $request)
    {
        $data = $request->all();

        $request->validate([

            'video'=>'required',
        ],
            [
                'video.required'=>'برجاء رفع الفيديو',
            ]
        );


        $intro_video = IntroVideo::query()->create([
            'path' => $data['video'],
            'teacher_id' => auth('teacher')->id(),
            'course_id' => $request->course_id,
        ]);

        return redirect()->route('intro_videos_index',$request->course_id)->with('alert-success','تم تحميل الفيديو بنجاح');
    }




    /*** show video ***/
    public function show($video_id)
    {
        $intro_video = IntroVideo::query()->findOrFail($video_id);

        return view('pages.intro_videos.show', compact('intro_video'));
    }



    /*** forceDelete country ***/
    public function forceDelete($id)
    {
        $intro_video = IntroVideo::query()->findOrFail($id);

        // delete from folder
        unlink(storage_path('/app/public/videos/'.$intro_video->path));

        $intro_video->forceDelete();
        return redirect()->back()->with('alert-danger','تم حذف البيانات بنجاح');
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
