@extends('layouts.master')

@section('title')
    إضافة كورس
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
                        <form action="{{route('courses.store')}}" method="post" enctype="multipart/form-data" name="myForm" onsubmit="return validateForm()">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">الاسم: </label>
                                    <input type="text" name="name" class="form-control" value="{{old('name')}}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">تاريخ الانتهاء: </label>
                                    <input type="date" name="end_date" class="form-control" value="{{old('end_date')}}" >
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label class="mr-sm-2">إمكانية التحميل: </label>
                                    <select class="form-control mr-sm-2 p-2 mr-md-0" name="download">
                                        <option class="custom-select mr-sm-2 p-2" value="2" {{old('download') == 2 ? 'selected' : ''}}>لا يمكن</option>
                                        <option class="custom-select mr-sm-2 p-2" value="1" {{old('download') == 1 ? 'selected' : ''}}>يمكن</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="name_ar" class="mr-sm-2">الوصف</label>
                                    <textarea name="description" class="form-control" rows="6">
                                        {{old('description')}}
                                    </textarea>
                                </div>
                            </div>

                            <br><br>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">حفظ</button>
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



        // // validation of the form
        // function validateForm() {
        //
        // }



    </script>


@endsection


