@extends('layouts.master')

@section('title')
    إضافة مدرس
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
                        <form action="{{route('store_teacher')}}" method="post" enctype="multipart/form-data" name="myForm" onsubmit="return validateForm()">
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

                            <div class="row">
                                <div class="col">
                                    <label class="mr-sm-2">نظام المدرس :</label>
                                    <select id="normal" class="form-control mr-sm-2 p-2 mr-md-0" name="normal">
                                        <option class="custom-select mr-sm-2 p-2" value="1" {{old('number_of_students') == 1 ? 'selected' : ''}}>عادي</option>
                                        <option class="custom-select mr-sm-2 p-2" value="2" {{old('number_of_students') == 2 ? 'selected' : ''}}>عدد طلاب</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row" id="numberOfStudents_row" >
                                <div class="col">
                                    <label class="mr-sm-2">أدخل عدد الطلاب :</label>
                                    <input type="number" class="form-control" name="number_of_students" value="{{old('number_of_students')}}">
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

            $('#normal').change(function (){
               if ($(this).val() === '2') {
                   $('#numberOfStudents_row').slideDown();
               }
               else {
                   $('#numberOfStudents_row').slideUp();
                   $('#numberOfStudents_row input').val('');
               }
            });
        });



        // validation of the form
        function validateForm() {

            let normal_value = $('#normal').find(':selected').val();
            let number_of_students = $('input[name="number_of_students"]').val();

            if (normal_value == "2")
            {
                if (number_of_students == "")
                {
                    alert('برجاء إدخال عدد الطلاب')
                    return false;
                }
            }
            else{
                $('#facebook_link_error').hide();
            }


        }



    </script>


@endsection


