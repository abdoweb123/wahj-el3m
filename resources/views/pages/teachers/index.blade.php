@extends('layouts.master')

@section('title')
    المدرسون
@stop

@section('style')
<style>
    select{padding:10px !important;}
    .process
    {
        cursor:pointer;
        background-color: #d4e3f026;
        border-radius:3px;
        border: 1px solid #dddd;
        padding: 5px 3px 0 4px;
        margin-left: 2px;
    }


</style>
@endsection

@section('PageTitle')
   قائمة المدرسين
@stop

@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-xl-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">

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

                    {{--  button of add_modal_employee  --}}
                    <a href="{{route('create_teacher_page')}}" class="button x-small">
                        إضافة مدرس
                    </a>
                    <br><br>

                    <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>البريد الإلكتروني</th>
                                <th>الحالة</th>
                                <th>العمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                             @foreach ($teachers as $item)
                                 @if($item->id !== auth()->id())
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>@if($item->active == 1)
                                            <a class="btn btn-primary" href="{{route('change_status',$item->id)}}">نشط</a>
                                        @else
                                            <a class="btn btn-danger" href="{{route('change_status',$item->id)}}">غير نشط</a>
                                        @endif
                                    </td>

                                    <td>
                                        <a type="button" class="process" href="{{route('show_teacher_data',$item->id)}}">
                                            <i style="color:green; font-size:18px;" class="fa fa-eye"></i></a>

                                        <a type="button" class="process" style="cursor:pointer" data-toggle="modal"
                                           data-target="#delete{{ $item->id }}">
                                            <i style="color:red; font-size:18px;" class="fa fa-trash"></i></a>
                                    </td>
                                </tr>

                                <!--  page of edit_modal_employee -->
{{--                                @include('pages.Drivers.edit')--}}

                                <!--  page of delete_modal_employee -->
                                @include('pages.teachers.delete')
                                @endif
                            @endforeach
                        </table>

                        <div> {{$teachers->links('pagination::bootstrap-4')}}</div>

                    </div>
                </div>
            </div>
        </div>


       <!--  page of add_modal_employee -->
{{--       @include('pages.Drivers.create')--}}
    </div>



@endsection
@section('script')
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function(){
            $(".messages").delay(5000).slideUp(300);
        });
    </script>
@endsection



