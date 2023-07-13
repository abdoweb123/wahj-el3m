<?php


if(!function_exists('company_name_arabic')){
    function company_name_arabic(){
        return 'وهج العلم';
    }
}


if(!function_exists('company_name_english')){
    function company_name_english(){
        return 'WAHJ EL3LM';
    }
}


//if(!function_exists('upload_course_video')){
//
//    function upload_course_video($request){
//        $files = [];
//        if($file = $request->file('video'))
//        {
//            $name = time().rand(1,100).'.'.$file->getClientOriginalExtension();
//            $file->move('courses/videos', $name);
//            $data['video']= $name;
//        }else{
//            $data['video']= null;
//        }
//        return $files;
//    }
//}










if(!function_exists('main_color_class_button_background')){
    function main_color_class_button_background(){
        return '#89CFF0';
    }
}


if(!function_exists('main_color_class_button_text_color')){
    function main_color_class_button_text_color(){
        return 'white';
    }
}


if(!function_exists('main_color_class_button_border')){
    function main_color_class_button_border(){
        return '#89CFF0';
    }
}


if(!function_exists('hover_and_focus_color_class_button_background')){
    function hover_and_focus_color_class_button_background(){
        return '#7ab4d0';
    }
}
