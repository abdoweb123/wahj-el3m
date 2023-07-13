<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

//    use AuthenticatesUsers;
//    protected $redirectTo = RouteServiceProvider::HOME;


    public function __construct()
    {
        $this->middleware('guest')->except('logoutTeacher');
    }


    /*** showLoginForm for teachers ***/
    public function showLoginFormTeacher()
    {
        return view('authTeacher.login');
    }


    /*** login for teachers ***/
    public function loginTeacher(LoginRequest $request){

        if (Auth::guard('teacher')->attempt(['email' => $request->email, 'password' => $request->password]))
        {
            $teacher = Auth::guard('teacher')->user();
            if ($teacher->active === 1){
                return redirect()->intended('teachers/dashboard');
            }
            else{
                Auth::guard('teacher')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->back()->withInput(['email','password'])->with('alert-danger', 'غير مصرح لك بالدخول, يمكنك التواصل مع الأدمن ');
            }

        }
        else{
            return redirect()->back()->withInput(['email','password'])->with('alert-danger', 'يوجد خطا في كلمة المرور او اسم المستخدم أو النوع');
        }
    }


    /*** logout for teachers ***/
    public function logoutTeacher(Request $request)
    {
        Auth::guard('teacher')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

}
