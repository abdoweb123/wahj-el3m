@extends('layouts.master')

@section('title')
    عرض بيانات الكورس
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
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="modal-body">
                        <form action="#">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">الاسم: </label>
                                    <input type="text" name="name" class="form-control" value="{{old('name',$course->name)}}" required readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">تاريخ الانتهاء: </label>
                                    <input type="date" name="end_date" class="form-control" value="{{old('end_date',$course->end_date)}}" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label class="mr-sm-2">إمكانية التحميل: </label>
                                    <input type="text" name="end_date" class="form-control" value="{{$course->download == 1 ? 'يمكن' : 'لا يمكن'}}" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">الوصف</label>
                                    <textarea name="description" class="form-control" rows="6" readonly>{{old('description',$course->description)}}</textarea>
                                </div>
                            </div>

                            <br><br>
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



        // // validation of the form
        // function validateForm() {
        //
        // }



    </script>


@endsection


