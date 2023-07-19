@extends('layouts.master')

@section('title')
    عرض الواجب
@stop


@section('style')
    <style>
        select{padding:10px !important;}
        /*#numberOfStudents_row{display: none}*/
    </style>
@endsection


@section('PageTitle')
    عرض الواجب
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
                    {!! $homework->content !!}

                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>
        $(document).ready(function () {

            $(".messages").delay(5000).slideUp(300);
        });
    </script>
@stop

