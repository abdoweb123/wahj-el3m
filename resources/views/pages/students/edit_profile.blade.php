@extends('layouts.master')


@section('title')
    تعديل بيانات الملف الشخصي
@stop


@section('style')
<style>
    select{padding:10px !important;}
    #numberOfStudents_row{display: none}</style>

@endsection

@section('PageTitle')
    تعديل بيانات الملف الشخصي
@stop

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


    @foreach(['danger','warning','success','info'] as $msg)
        @if(Session::has('alert-'.$msg))
            <div class="alert alert-{{$msg}} messages tostr">
                {{Session::get('alert-'.$msg)}}
            </div>
        @endif
    @endforeach

    <!-- row -->
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="modal-body">
                        <form action="{{route('update_teacher_profile')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <label for="name" class="mr-sm-2">الاسم :</label>
                                    <input id="name" type="text" name="name" class="form-control" value="{{$teacher->name}}" >
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label for="email" class="mr-sm-2">البريد الإلكتروني :</label>
                                    <input id="email" type="text" name="email" class="form-control" value="{{$teacher->email}}" >
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label for="password" class="mr-sm-2">كلمة المرور :</label>
                                    <input type="password" class="form-control" name="password">
                                </div>
                            </div>

                            <br><br>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">تعديل</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
@section('script')
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function(){
            $(".alert").delay(5000).slideUp(300);

        });



    </script>
@endsection





