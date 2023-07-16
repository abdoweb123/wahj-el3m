@extends('layouts.master')

@section('title')
    عرض بيانات المدرس
@stop


@section('style')
    <style>
        select{padding:10px !important;}
        /*#numberOfStudents_row{display: none}*/
    </style>
@endsection


@section('PageTitle')
    عرض بيانات المدرس
@stop

@section('content')

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
                        <form action="{{route('update_teacher_system')}}" method="post" enctype="multipart/form-data" name="myForm" onsubmit="return validateForm()">
                            @csrf
                            @method('post')
                            <input type="hidden" name="teacher_id" value="{{$teacher->id}}">
                            <div class="row">
                                <div class="col">
                                    <label for="name" class="mr-sm-2">الاسم :</label>
                                    <input id="name" type="text" class="form-control" value="{{$teacher->name}}" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label for="email" class="mr-sm-2">البريد الإلكتروني :</label>
                                    <input id="email" type="text" class="form-control" value="{{$teacher->email}}" readonly>
                                </div>
                            </div>

                            <div class="row">
{{--                                <div class="col">--}}
{{--                                    <label class="mr-sm-2">نظام المدرس :</label>--}}
{{--                                    <input type="text" class="form-control" name="normal" value="{{$teacher->normal == 1 ? 'عادي' : 'عدد طلاب'}}">--}}
{{--                                </div>--}}

                                <div class="col">
                                    <label class="mr-sm-2">نظام المدرس :</label>
                                    <select id="normal" class="form-control mr-sm-2 p-2 mr-md-0" name="normal">
                                        <option class="custom-select mr-sm-2 p-2" value="1" {{$teacher->normal == 1 ? 'selected' : ''}}>عادي</option>
                                        <option class="custom-select mr-sm-2 p-2" value="2" {{$teacher->normal == 2 ? 'selected' : ''}}>عدد طلاب</option>
                                    </select>
                                </div>
                            </div>


                                <div class="row" id="numberOfStudents_row" style="@if($teacher->normal == 1 ) display:none @endif">
                                    <div class="col">
                                        <label class="mr-sm-2"> عدد الطلاب :</label>
                                        <input type="number" class="form-control" name="number_of_students" value="{{$teacher->number_of_students}}">
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
    <script>
        $(document).ready(function (){

            $(".messages").delay(5000).slideUp(300);

            $('#normal').change(function (){
                if ($(this).val() === '2') {
                    $('#numberOfStudents_row').slideDown();
                }
                else {
                    $('#numberOfStudents_row').slideUp();
                    // $('#numberOfStudents_row input').val('');
                }
            });

        });
    </script>
@stop

