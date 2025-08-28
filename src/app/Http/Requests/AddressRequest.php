<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'destination_post_code' => 'required|size:8|regex:/\d{3}-\d{4}$/',
            'destination_address' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'destination_post_code.required' => '郵便番号を入力してください',
            'destination_post_code.size' => '郵便番号はハイフンありの数字８文字で入力してください',
            'destination_post_code.regex' => '郵便番号はハイフンありの数字８文字(xxx-xxxxの形）で入力してください',
            'destination_address.required' => '住所を入力してください',
        ];
    }
}
