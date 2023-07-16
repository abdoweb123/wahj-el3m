<?php

namespace App\Http\Controllers;


use App\Models\PdfVideo;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class PdfVideoController extends Controller
{
    /*** get videos ***/
    public function index($video_id)
    {
        $pdfs_video = PdfVideo::query()->where('teacher_id',auth('teacher')->id())
            ->where('video_id',$video_id)->latest()->paginate(page);

        $video = Video::query()->findOrFail($video_id);

        return view('pages.pdfs_video.index', compact('pdfs_video','video'));
    }



    /*** create video ***/
    public function create($video_id)
    {
        $video = Video::query()->findOrFail($video_id);

        return view('pages.pdfs_video.create', compact('video'));
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


        $pdfs_video = PdfVideo::query()->create([
            'name' => $request->name,
            'active' => 1,
            'path' => $data['pdf'],
            'teacher_id' => auth('teacher')->id(),
            'video_id' => $request->video_id,
        ]);

        return redirect()->route('pdfs_video_index',$request->video_id)->with('alert-success','تم تحميل المستند بنجاح');
    }




    /*** show video ***/
    public function show($pdf_id)
    {
        $pdfs_video = PdfVideo::query()->findOrFail($pdf_id);

        return response()->file(storage_path('/app/public/videos/'.$pdfs_video->path));
    }



    /*** forceDelete country ***/
    public function forceDelete($id)
    {
        $pdfs_video = PdfVideo::query()->findOrFail($id);

        // delete from folder
        unlink(storage_path('/app/public/videos/'.$pdfs_video->path));

        $pdfs_video->forceDelete();
        return redirect()->back()->with('alert-danger','تم حذف البيانات بنجاح');
    }



    /*** change Status of video ***/
    public function changeStatus($id)
    {
        $pdfs_video = PdfVideo::query()->where('id',$id)->first();

        if ($pdfs_video->active == 1)
        {
            $pdfs_video->active = 2;
        }else{
            $pdfs_video->active = 1;
        }
        $pdfs_video->save();

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
