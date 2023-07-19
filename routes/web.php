<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\IntroVideoController;
use App\Http\Controllers\PdfCourseController;
use App\Http\Controllers\PdfVideoController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\VideoHomeworkController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {return view('authTeacher.login');})->name('/');

define('page' , 100);


Auth::routes();

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function(){

//    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


    // teachers
    Route::group(['prefix'=>'teachers'], function ()
    {
        Route::get('/login/page', [LoginController::class,'showLoginFormTeacher'])->name('login_teacher_page');
        Route::post('/login/process', [LoginController::class,'loginTeacher'])->name('login_teacher');


        Route::group(['middleware'=>['auth:teacher','isActive']], function () {


            Route::get('/dashboard',[TeacherController::class,'teacherDashboard'])->name('dashboard_teacher');
            Route::post('/logout', [LoginController::class,'logoutTeacher'])->name('logout_teacher');
            Route::get('/edit/profile', [TeacherController::class,'editProfile'])->name('edit_teacher_profile');
            Route::post('/update/profile', [TeacherController::class,'updateProfile'])->name('update_teacher_profile');

            Route::group(['middleware'=>['isAdmin']], function () {
                Route::get('/get/all', [TeacherController::class,'index'])->name('get_all_teachers');
                Route::get('/create/page', [TeacherController::class,'create'])->name('create_teacher_page');
                Route::post('/store', [TeacherController::class,'store'])->name('store_teacher');
                Route::get('/force/delete/{id}', [TeacherController::class,'forceDelete'])->name('force_delete_teacher');
                Route::get('/show/{id}', [TeacherController::class,'show'])->name('show_teacher_data');
                Route::post('/update/system', [TeacherController::class,'updateSystem'])->name('update_teacher_system');
                Route::get('/change/status/{id}', [TeacherController::class,'changeStatus'])->name('change_status');
            });


            //courses
            Route::group(['prefix'=>'courses'], function ()
            {
                Route::resource('courses', CourseController::class);
                Route::get('/change/status/{id}', [CourseController::class,'changeStatus'])->name('change_status_course');
                Route::get('/force/delete/{id}', [CourseController::class,'forceDelete'])->name('force_delete_course');
            });


            //videos
            Route::group(['prefix'=>'videos'], function ()
            {
                Route::get('index/{course_id}', [VideoController::class,'index'])->name('videos_index');
                Route::get('create/{course_id}', [VideoController::class,'create'])->name('video_create');

                // upload and store video
                Route::get('file-upload', [VideoController::class, 'index'])->name('files.index');
                Route::post('file-upload/upload-large-files', [VideoController::class, 'uploadLargeFiles'])->name('files.upload.large');
                Route::post('store', [VideoController::class,'store'])->name('video_store');

                Route::get('show/{video_id}', [VideoController::class,'show'])->name('video_show');
                Route::get('/change/status/{id}', [VideoController::class,'changeStatus'])->name('change_status_video');
                Route::get('/force/delete/{id}', [VideoController::class,'forceDelete'])->name('force_delete');
            });


            //intro videos
            Route::group(['prefix'=>'intro/videos'], function ()
            {
                Route::get('index/{course_id}', [IntroVideoController::class,'index'])->name('intro_videos_index');
                Route::get('create/{course_id}', [IntroVideoController::class,'create'])->name('intro_video_create');

                // upload and store video
                Route::post('file-upload/intro/video', [IntroVideoController::class, 'uploadLargeFiles'])->name('upload_intro_video');
                Route::post('store', [IntroVideoController::class,'store'])->name('intro_video_store');

                Route::get('show/{video_id}', [IntroVideoController::class,'show'])->name('intro_video_show');
                Route::get('/force/delete/{id}', [IntroVideoController::class,'forceDelete'])->name('force_delete_intro_video');
            });



            //pdfs courses
            Route::group(['prefix'=>'course/pdfs'], function ()
            {
                Route::get('index/{course_id}', [PdfCourseController::class,'index'])->name('pdfs_course_index');
                Route::get('create/{course_id}', [PdfCourseController::class,'create'])->name('pdfs_course_create');
                // upload and (crud) pdf course
                Route::post('file-upload/pdf/course', [PdfCourseController::class, 'uploadLargeFiles'])->name('upload_pdfs_course');
                Route::post('store', [PdfCourseController::class,'store'])->name('pdfs_course_store');
                Route::get('show/{pdf_id}', [PdfCourseController::class,'show'])->name('pdfs_course_show');
                Route::get('/change/status/{id}', [PdfCourseController::class,'changeStatus'])->name('change_status_pdfs_course');
                Route::get('/force/delete/{id}', [PdfCourseController::class,'forceDelete'])->name('force_delete_pdfs_course');
            });


            //pdfs videos
            Route::group(['prefix'=>'video/pdfs'], function ()
            {
                Route::get('index/{video_id}', [PdfVideoController::class,'index'])->name('pdfs_video_index');
                Route::get('create/{video_id}', [PdfVideoController::class,'create'])->name('pdfs_video_create');
                // upload and (crud) pdf video
                Route::post('file-upload/pdf/video', [PdfVideoController::class, 'uploadLargeFiles'])->name('upload_pdfs_video');
                Route::post('store', [PdfVideoController::class,'store'])->name('pdfs_video_store');
                Route::get('show/{pdf_id}', [PdfVideoController::class,'show'])->name('pdfs_video_show');
                Route::get('/change/status/{id}', [PdfVideoController::class,'changeStatus'])->name('change_status_pdfs_video');
                Route::get('/force/delete/{id}', [PdfVideoController::class,'forceDelete'])->name('force_delete_pdfs_video');
            });



            //pdfs videos
            Route::group(['prefix'=>'video/homework'], function ()
            {
                Route::get('index/{video_id}', [VideoHomeworkController::class,'index'])->name('videoHomework_video_index');
                Route::get('create/{video_id}', [VideoHomeworkController::class,'create'])->name('videoHomework_video_create');
                Route::post('store', [VideoHomeworkController::class,'store'])->name('videoHomework_video_store');
                Route::get('show/{id}', [VideoHomeworkController::class,'show'])->name('videoHomework_video_show');
                Route::get('edit/{id}', [VideoHomeworkController::class,'edit'])->name('videoHomework_video_edit');
                Route::post('update/{id}', [VideoHomeworkController::class,'update'])->name('videoHomework_video_update');
                Route::get('/force/delete/{id}', [VideoHomeworkController::class,'forceDelete'])->name('force_delete_videoHomework_video');
            });



            // students of teacher
            Route::group(['prefix'=>'students'], function ()
            {
                Route::get('index', [StudentController::class,'index'])->name('students_index');
                Route::get('create', [StudentController::class,'create'])->name('students_create');
                Route::get('/change/status/{id}', [StudentController::class,'changeStatus'])->name('change_status_student');
                Route::post('/store', [StudentController::class,'store'])->name('store_student');
                Route::get('/force/delete/{id}', [StudentController::class,'forceDelete'])->name('force_delete_student');



            });

        });
    });



    // students
    Route::group(['prefix'=>'students', 'middleware'=>'auth:students'], function ()
    {
        Route::group(['middleware'=>'auth:student'], function () {
            Route::get('/dashboard', function (){return view('layouts.master');})->name('master');
        });
    });



});

