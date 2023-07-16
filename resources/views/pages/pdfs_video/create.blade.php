@extends('layouts.master')

@section('title')
    إضافة مستند
@stop



@section('style')
<style>
    select{padding:10px !important;}
    .card-footer, .progress {
        display: none;
    }
</style>

@endsection



@section('content')


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- row -->
    <div class="row">

        <div class="row w-100">
            <div class="col">
                <h5 style="margin-right:20px; color:#1a1ac3; text-align: center">
                    <span> {{$video->name}} </span>
                </h5>
            </div>
        </div>

        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="modal-body">
{{--                        <form action="{{route('video_store')}}" method="post" enctype="multipart/form-data" name="myForm" onsubmit="return validateForm()">--}}
                        <form action="{{route('pdfs_video_store')}}" method="post" enctype="multipart/form-data" name="myForm">
                            @csrf

                            <input type="hidden" name="video_id" value="{{$video->id}}">
                            <div class="row">
                                <div class="col">
                                    <label for="name" class="mr-sm-2">الاسم :</label>
                                    <input id="name" type="text" name="name" class="form-control" placeholder="الجزء الاول" value="{{old('name')}}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label class="mr-sm-2"> قم برفع الملف :</label>
                                    <div id="upload-container" class="text-center">
                                        <input id="browseFile" class="btn btn-primary" value="اختر ملف">
                                        <input id="showFile" type="hidden" value="" name="pdf" required>
                                    </div>
                                </div>
                            </div>

                            <div class="progress mt-3" style="height: 25px">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 2%; height: 100%">0%</div>
                            </div>

                            <br><br>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success" id="submit" disabled>حفظ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('script_files')
    <script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>
@stop


@section('script')
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function(){
            $(".alert").delay(5000).slideUp(300);
        });



        // // // validation of the form
        // function validateForm() {
        //     $('#submit').prop('disabled',true);
        //     alert(' سيتم تحميل الفيديو الاّن برجاء الانتظار');
        // }

    </script>


    <script type="text/javascript">
        let browseFile = $('#browseFile');
        let resumable = new Resumable({
            target: '{{ route('upload_pdfs_video') }}',
            query:{_token:'{{ csrf_token() }}'} ,// CSRF token
            fileType: ['pdf'],
            headers: {
                'Accept' : 'application/json'
            },
            testChunks: false,
            throttleProgressCallbacks: 1,
        });

        resumable.assignBrowse(browseFile[0]);

        resumable.on('fileAdded', function (file) { // trigger when file picked
            showProgress();
            resumable.upload() // to actually start uploading.
        });

        resumable.on('fileProgress', function (file) { // trigger when file progress update
            updateProgress(Math.floor(file.progress() * 100));
        });

        resumable.on('fileSuccess', function (file, response) { // trigger when file upload complete
            response = JSON.parse(response)
            $('#videoPreview').attr('src', response.path);
            $('.card-footer').show();

            // code of mine
            $('#showFile').val(response.filename);
            $('#submit').attr('disabled',false);
        });

        resumable.on('fileError', function (file, response) { // trigger when there is any error
            alert('file uploading error.')
        });


        let progress = $('.progress');
        function showProgress() {
            progress.find('.progress-bar').css('width', '0%');
            progress.find('.progress-bar').html('0%');
            progress.find('.progress-bar').removeClass('bg-success');
            progress.show();
        }

        function updateProgress(value) {
            progress.find('.progress-bar').css('width', `${value}%`)
            progress.find('.progress-bar').html(`${value}%`)
        }

        function hideProgress() {
            progress.hide();
        }
    </script>


@endsection


