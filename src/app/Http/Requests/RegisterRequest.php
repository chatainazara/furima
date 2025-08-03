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
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:20',
            'email' => 'required|email|unique:users,email',
            // 指示にないがエラー回避のためuniqueを追加
            'password' => 'required|confirmed|min:8',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'お名前を入力してください',
            // 'name.max' => 'お名前は20文字以内で入力してください',
            // 上記は仕様にないためコメントアウト
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはメール形式で入力してください',
            'password.required' => 'パスワードを入力してください',
            'password.confirmed' => 'パスワードと一致しません',
            'password.min' => 'パスワードは８文字以上で入力してください',
        ];
    }
}
