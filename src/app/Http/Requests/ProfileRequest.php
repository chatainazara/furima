<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'pict_url' => 'mimes:jpeg,png',
            'post_code' => 'required|size:8|regex:/\d{3}-\d{4}$/',
            'address' => 'required',
        ];

    }

    public function messages()
    {
        return [
            'name.required' => 'お名前を入力してください',
            'name.max' => 'お名前は20文字以内で入力してください',
            'pict_url.mimes' => 'jpeg,pngのフェイルを選択してください',
            'post_code.required' => '郵便番号を入力してください',
            'post_code.size' => '郵便番号はハイフンありの数字８文字で入力してください',
            'post_code.regex' => '郵便番号はハイフンありの数字８文字(xxx-xxxxの形）で入力してください',
            'address.required' => '住所を入力してください',
        ];
    }
}
