<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class VideoController extends Controller
{

    /*** get videos ***/
    public function index($course_id)
    {
        $videos = Video::query()->where('teacher_id',auth('teacher')->id())
            ->where('course_id',$course_id)->latest()->paginate(page);

        $course = Course::query()->findOrFail($course_id);

        return view('pages.videos.index', compact('videos','course'));
    }



    /*** create video ***/
    public function create($course_id)
    {
        $course = Course::query()->findOrFail($course_id);

        return view('pages.videos.create', compact('course'));
    }



    /*** store country ***/
    public function store(Request $request)
    {
        $data = $request->all();

        $request->validate([
            'name'=>'required',
//            'video'=>'required|mimes:mp4,mov,ogg,qt',
            'video'=>'required',
        ],
            [
                'name.required'=>' الاسم مطلوب',
                'video.required'=>'برجاء رفع الفيديو',
//                'video.mimes'=>'يجب أن يكون الفيديو من نوع mp4,mov,ogg,qt',
            ]
        );


        $video = Video::query()->create([
            'name' => $request->name,
            'active' => 1,
            'path' => $data['video'],
            'teacher_id' => auth('teacher')->id(),
            'course_id' => $request->course_id,
        ]);

        return redirect()->route('videos_index',$request->course_id)->with('alert-success','تم تحميل الفيديو بنجاح');
    }




    /*** show video ***/
    public function show($video_id)
    {
        $video = Video::query()->findOrFail($video_id);

        return view('pages.videos.show', compact('video'));
    }



    /*** forceDelete country ***/
    public function forceDelete($id)
    {
        $video = Video::query()->findOrFail($id);

        // delete from folder
        unlink(storage_path('/app/public/videos/'.$video->path));

        $video->forceDelete();
        return redirect()->back()->with('alert-danger','تم حذف البيانات بنجاح');
    }



    /*** change Status of video ***/
    public function changeStatus($id)
    {
        $video = Video::query()->where('id',$id)->first();

        if ($video->active == 1)
        {
            $video->active = 2;
        }else{
            $video->active = 1;
        }
        $video->save();

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
