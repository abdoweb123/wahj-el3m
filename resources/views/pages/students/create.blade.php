@extends('layouts.master')

@section('title')
    إضافة طالب
@stop

@section('style')



<style>
    select{padding:10px !important;}
    #numberOfStudents_row{display: none}
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
                        <form action="{{route('store_student')}}" method="post" enctype="multipart/form-data" name="myForm" onsubmit="return validateForm()">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <label for="name" class="mr-sm-2">الاسم :</label>
                                    <input id="name" type="text" name="name" class="form-control" value="{{old('name')}}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label for="email" class="mr-sm-2">البريد الإلكتروني :</label>
                                    <input id="email" type="text" name="email" class="form-control" value="{{old('email')}}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label for="password" class="mr-sm-2">كلمة المرور :</label>
                                    <input type="password" class="form-control" name="password" required>
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



        // validation of the form
        // function validateForm() {
        //
        //
        // }



    </script>


@endsection


