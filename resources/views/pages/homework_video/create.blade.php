@extends('layouts.master')

@section('title')
    إضافة واجب
@stop



@section('style')
<style>
    select{padding:10px !important;}
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
                        <form action="{{route('videoHomework_video_store')}}" method="post" enctype="multipart/form-data" name="myForm" onsubmit="return validateForm()">
                            @csrf

                            <input type="hidden" name="video_id" value="{{$video->id}}">
                            <div class="row">
                                <div class="col">
                                    <label for="name" class="mr-sm-2">الاسم :</label>
                                    <input id="name" type="text" name="name" class="form-control" placeholder="الواجب" value="{{old('name')}}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">الوصف</label>
                                    <textarea id="description" name="content" class="form-control" rows="6" style="direction: ltr;" required>
                                        {{old('content')}}
                                    </textarea>
                                </div>
                            </div>


                            <br><br>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success" id="submit">حفظ</button>
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


    </script>




@endsection


