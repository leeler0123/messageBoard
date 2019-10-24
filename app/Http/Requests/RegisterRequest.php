<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|max:30|min:6|unique:user',
            'email' => 'required|email|unique:user',
            'password' => 'required|min:6|max:16',
            'password_confirm' => 'required|same:password',
            'captcha' => 'required|captcha'
        ];
    }

    public function messages()
    {
        return [
            'username.required' => '用户名不能为空',
            'username.max|username.min'  => '用户名必须设置在6-30字符之间',
            'email.required' => 'email不能为空'
        ];
    }
}
