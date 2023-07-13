@extends('layouts.master')

@section('title')
   الفيديو التعريفي للكورس
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

    #datatable_filter, .dataTables_length{
        display: none;
    }
</style>

@endsection


@section('content')
    <!-- row -->
    <div class="row">

        <div class="row w-100 justify-content-between">
           <div class="col">
               <h5 style="margin-right:20px; color:#1a1ac3;">
                   <span> الكورسات </span> <span>/</span>  <span> الفيديو التعريفي </span>
               </h5>
           </div>

            <div class="col">
               <h5 style="margin-right:20px; color:#1a1ac3; text-align: end">
                   <span> {{$course->name}} </span>
               </h5>
           </div>
        </div>

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

                    @if($intro_video->isEmpty())
                        <a href="{{route('intro_video_create',$course->id)}}" class="button x-small">
                            إضافة فيديو
                        </a>
                    @endif
                    <br><br>

                    <div class="table-responsive">
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                               style="text-align: center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>نسخ المسار</th>
                                <th>الإجراءات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($intro_video as $item)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>الفيديو التعريفي</td>
                                    <td id="copy_td">
                                        <span style="display: none" id="link_to_be_copied">{{asset('/storage/videos/'.$item->path)}}</span>
                                        <span class="d-block btn btn-sm w-50 m-auto copy_link" style="border: 1px solid #8ee290; margin-top: 5px !important;">
                                          <i class="fa fa-copy"></i>&nbsp;نسخ
                                        </span>
                                        <span class="d-block text-center say_copied" style="color:#b04a4a; visibility:hidden;">تم النسخ!</span>
                                    </td>
{{--                                    <td>@isset($item->admin->name)  {{ $item->admin->name }} @else _____  @endisset</td>--}}


                                    <td>
                                        <a href="{{route('intro_video_show',$item->id)}}" class="process" style="cursor:pointer">
                                            <i style="color:green; font-size:18px;" class="fa fa-eye"></i></a>

                                        <a type="button" class="process" style="cursor:pointer" data-toggle="modal"
                                           data-target="#delete{{ $item->id }}" title="{{ trans('main_trans.delete') }}">
                                            <i style="color:red; font-size:18px;" class="fa fa-trash"></i></a>
                                    </td>

                                </tr>

                                <!--  page of delete_modal_city -->
                                @include('pages.intro_videos.delete')


                            @endforeach
                        </table>

                        <div> {{$intro_video->links('pagination::bootstrap-4')}}</div>
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



        $('.copy_link').click(function (){

            var copyText = $(this).parent().children(':first').prop('innerText');

            navigator.clipboard.writeText(copyText);

            // show copied
            $(this).next().css('visibility','visible');
            setTimeout(function (){
                $('.say_copied').css('visibility','hidden');
            },2000);
        });




    </script>
@endsection




