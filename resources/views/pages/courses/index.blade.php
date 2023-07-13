@extends('layouts.master')

@section('title')
    قائمة الكورسات
@stop

@section('style')


<style>
    .process{border:none; border-radius:3px; padding:3px 5px;}
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


                    <a href="{{route('courses.create')}}" class="button x-small">
                        إضافة كورس
                    </a>
                    <br><br>

                    <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($courses as $item)
                                <tr>

                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>@if($item->active == 1)
                                            <a class="btn btn-primary" href="{{route('change_status_course',$item->id)}}">نشط</a>
                                        @else
                                            <a class="btn btn-danger" href="{{route('change_status_course',$item->id)}}">غير نشط</a>
                                        @endif
                                    </td>
{{--                                    <td>@isset($item->admin->name)  {{ $item->admin->name }} @else _____  @endisset</td>--}}

                                    <td>
                                        <div class="dropdown show">
                                            <a class="btn btn-success btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                العمليات
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">

                                                <a class="dropdown-item" type="button" href="#"
                                                   data-toggle="modal" data-target="#edit{{ $item->id }}">
                                                    <i style="color: #ffc107" class="fa fa-eye"></i>&nbsp تعديل</a>

                                                <a class="dropdown-item" type="button" href="#"
                                                   data-toggle="modal" data-target="#delete{{ $item->id }}">
                                                    <i style="color: red" class="fa fa-trash"></i>&nbsp حذف</a>

                                                <a class="dropdown-item" href="{{route('videos_index',$item->id)}}">
                                                    <i style="color: #25bb19" class="fa fa-video"></i>&nbsp; فيديوهات الكورس </a>

                                                <a class="dropdown-item" href="{{route('pdfs_course_index',$item->id)}}">
                                                    <i style="color: #acabcb" class="fa fa-file-pdf-o"></i>&nbsp;مستندات الشرح  </a>

                                                <a class="dropdown-item" href="{{route('intro_videos_index',$item->id)}}">
                                                    <i style="color: #acabcb" class="fa fa-star"></i>&nbsp; الفيديو التعريفي </a>

                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!--  page of edit_modal_city -->
                                @include('pages.courses.edit')

                                <!--  page of delete_modal_city -->
                                @include('pages.courses.delete')


                            @endforeach
                        </table>

                        <div> {{$courses->links('pagination::bootstrap-4')}}</div>
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




