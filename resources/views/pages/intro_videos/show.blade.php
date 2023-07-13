<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <!--- Style css -->
    @if (App::getLocale() == 'ar')
        <link href="{{ URL::asset('assets/css/rtl.css') }}" rel="stylesheet">
        <style>
            .mr-auto, .mx-auto {
                margin-right: initial !important;
            }

            .ml-auto, .mx-auto {
                margin-left: initial !important;
            }
        </style>
    @else
        <link href="{{ URL::asset('assets/css/ltr.css') }}" rel="stylesheet">
    @endif


    <style>
        /*.dataTables_paginate,*/
        /*.dataTables_info*/
        /*{display:none}*/

        select.form-control-sm:not([size]):not([multiple]){padding:10px}

        .pagination {justify-content:center}
        .modal-body .row{margin-top:13px;}


        body,h1,h2,h3,h4,h5,h6{font-family: Cairo,'tahoma','sans-serif' !important;}
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button{
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number]{
            -moz-appearance: textfield;
        }

        /*.dataTables_length{display: none}*/
        .messages , .alert-danger {width:30%}

        {{--
   .button , .btn-success , input[type='submit'] , #head
   , .tab .nav.nav-tabs li a.active, .tab .nav.nav-tabs li a.active:hover,
   .button.button-border
   {
       background-color: <?php echo main_color_class_button_background(); ?> !important;
       border-color: <?php echo main_color_class_button_border(); ?> !important;
       color: <?php echo main_color_class_button_background(); ?>;
   }
   .button:hover, .button:focus,
   .btn-success:hover, .btn-success:focus,
   .btn-success:active,
   .btn-success:not(:disabled):not(.disabled).active,
   .btn-success:not(:disabled):not(.disabled):active,
   .show > .btn-success.dropdown-toggle
   {
       background-color: <?php echo hover_and_focus_color_class_button_background(); ?> !important;
       border-color: <?php echo main_color_class_button_border(); ?> !important;
   }
   .admin-header.navbar .navbar-brand-wrapper
   .navbar-brand{
       margin-right: 0
   }
--}}

   a:hover{
            text-decoration: none !important;
        }

        input::-webkit-input-placeholder{
            color: black;
            opacity: 0.5 !important;
        }

        .tostr{
            position: fixed;
            top: 17px;
            left: 10px;
            z-index: 999999;
            width: 20%;
        }


    </style>




   {{-- start formatting the video --}}
    <style>
        body{
            background-color: #e2e0e091;
        }
        .container {
            position: relative;
            display: flex;
            width: max-content;
            height: max-content;
            justify-content: center;
            align-items: center;
            margin: auto;
            margin-top: 5%;
        }
        .container #video {
            width: 600px;
            height: 400px;
            border-radius: 20px;
            background-color: black;
            padding-bottom: 25px;
        }
        .container .controls {
            position: absolute;
            bottom: 40px;
            width: 95%;
            display: flex;
            justify-content: space-around;
            opacity: 0.2;
            transition: opacity 0.4s;
        }
        .container:hover .controls {
            opacity: 1;
        }
        .container .controls button {
            background: transparent;
            color: #fff;
            font-weight: bolder;
            text-shadow: 2px 1px 2px #000;
            border: none;
            cursor: pointer;
        }
        .container .controls .timeline {
            flex: 1;
            display: flex;
            align-items: center;
            border: none;
            border-right: 3px solid #ccc;
            border-left: 3px solid #ccc;
        }
        .container .controls .timeline .bar{
            background: rgb(1, 1, 65);
            height: 4px;
            flex: 1;
        }
        .container .controls .timeline .bar .inner{
            background: #ccc;
            width: 0%;
            height: 100%;
        }
        .fa {
            font-size: 20px !important;
        }
        video{
            border: 1px solid #ddd;
        }

        video::-webkit-media-controls-enclosure{
            display: none !important;
        }


        /*#pre-loader{*/
        /*    display: none;*/
        /*}*/
    </style>
    {{-- end formatting the video --}}

</head>
<body>

<div id="pre-loader">
    <img src="{{asset('assets/images/pre-loader/loader-01.svg')}}" alt="">
</div>

<div class="container">



    <video onclick="play(event)" src="{{asset('/storage/videos/'.$intro_video->path)}}" id="video"></video>


    <div class="controls">
        <button onclick="play(event)"><i class="fa fa-play"></i><i class="fa fa-pause"></i></button>
        <button onclick="rewind(event)"><i class="fa fa-fast-backward"></i></button>
        <div class="timeline">
            <div class="bar">
                <div class="inner"></div>
            </div>
        </div>
        <button onclick="forward(event)"><i class="fa fa-fast-forward"></i></button>
        <button onclick="fullScreen(event)"><i class="fa fa-expand"></i></button>
    </div>
</div>
<script src="script.js"></script>


<!-- jquery -->
<script src="{{ URL::asset('assets/js/jquery-3.3.1.min.js') }}"></script>
<!-- plugins-jquery -->
<script src="{{ URL::asset('assets/js/plugins-jquery.js') }}"></script>
<script src="{{ URL::asset('assets/js/custom.js') }}"></script>




{{-- start formatting the video --}}
<script>
    // Select the HTML5 video
    const video = document.querySelector("#video")
    // set the pause button to display:none by default
    document.querySelector(".fa-pause").style.display = "none"
    // update the progress bar
    video.addEventListener("timeupdate", () => {
        let curr = (video.currentTime / video.duration) * 100
        if(video.ended){
            document.querySelector(".fa-play").style.display = "block"
            document.querySelector(".fa-pause").style.display = "none"
        }
        document.querySelector('.inner').style.width = `${curr}%`
    })
    // pause or play the video
    const play = (e) => {
        // Condition when to play a video
        if(video.paused){
            document.querySelector(".fa-play").style.display = "none"
            document.querySelector(".fa-pause").style.display = "block"
            video.play()
        }
        else{
            document.querySelector(".fa-play").style.display = "block"
            document.querySelector(".fa-pause").style.display = "none"
            video.pause()
        }
    }
    // trigger fullscreen
    const fullScreen = (e) => {
        e.preventDefault()
        video.requestFullscreen()
    }
    // download the video
    // deleted

    // rewind the current time
    const rewind = (e) => {
        video.currentTime = video.currentTime - ((video.duration/100) * 5)
    }
    // forward the current time
    const forward = (e) => {
        video.currentTime = video.currentTime + ((video.duration/100) * 5)
    }
</script>
  {{-- end formatting the video --}}


</body>
</html>
