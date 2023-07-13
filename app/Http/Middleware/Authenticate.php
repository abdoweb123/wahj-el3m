<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            if (in_array('auth:teacher',$request->route()->middleware())){
                return route('login_teacher_page');
            }
            elseif (in_array('auth:student',$request->route()->middleware())){
                return route('login_student_page');
            }
            else{
                return route('login_teacher_page');
            }
        }

    }
}

