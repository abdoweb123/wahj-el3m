@extends('layouts.master')

@section('title')
    الصفحة الرئيسية
@endsection


@section('style')

    <style>
        .col-md-3 , .col-md-6{
            cursor:pointer;
        }
        .div-dash a{color:black !important; text-decoration:none}
        .div-dash div img{
            height: 55%;
            width: 100%;
            object-fit: cover;
        }
    </style>
@endsection




@section('content')

    <div class="row">
        <div class="col-xl col-lg-3 col-md-4 col-sm-6">
            <div class="card card-statistics h-75">
                <div class="card-body">
                    <div class="clearfix">
                        <div class="text-center pb-4">
                            <p>
                                <span class="icon_card">
                                    <i class="fa fa-users highlight-icon" style="font-size:25px !important;" aria-hidden="true"></i>
                                </span>
                            </p>
                            <p class="card-text text-dark">عدد المدرسين</p>
                            <p><span class="value">{{\App\Models\Teacher::count()-1}}</span> <span class="pound"></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl col-lg-3 col-md-4 col-sm-6">
            <div class="card card-statistics h-75">
                <div class="card-body">
                    <div class="clearfix">
                        <div class="text-center pb-4">
                            <p>
                                <span class="icon_card">
                                    <i class="fa fa-users highlight-icon" style="font-size:25px !important;" aria-hidden="true"></i>
                                </span>
                            </p>
                            <p class="card-text text-dark">عدد المدرسين</p>
                            <p><span class="value">{{\App\Models\Teacher::count()-1}}</span> <span class="pound"></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl col-lg-3 col-md-4 col-sm-6">
            <div class="card card-statistics h-75">
                <div class="card-body">
                    <div class="clearfix">
                        <div class="text-center pb-4">
                            <p>
                                <span class="icon_card">
                                    <i class="fa fa-users highlight-icon" style="font-size:25px !important;" aria-hidden="true"></i>
                                </span>
                            </p>
                            <p class="card-text text-dark">عدد المدرسين</p>
                            <p><span class="value">{{\App\Models\Teacher::count()-1}}</span> <span class="pound"></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
