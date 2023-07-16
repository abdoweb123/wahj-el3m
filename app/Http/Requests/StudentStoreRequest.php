<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentStoreRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name'=>'required',
            'email'=>'required|email|unique:students',
            'password'=>'required',
        ];
    }

    public function messages()
    {
        return [
          'name.required'=>' الاسم مطلوب',
          'email.required'=>' البريد الإلكتروني مطلوب',
          'password.required'=>'كلمة المرور مطلوبة',
        ];
    }
}
