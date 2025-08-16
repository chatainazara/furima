<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'name' => 'required',
            // 'pict_url' => 'required|mimes:jpeg,png',
            'price' => 'required|integer|min:1',
            'detail' => 'required||max:255',
            'condition' =>'required',
            'categories' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',
            'pict_url.required' => '画像ファイルを選択してください',
            'pict_url.mimes' => 'jpeg,pngのフェイルを選択してください',
            'price.required' => '金額を入力してください',
            'price.integer' => '数字を入力してください',
            'price.integer' => '1円以上の金額を入力してください',
            'detail.required' => '商品の説明を入力してください',
            'detail.max' => '255文字以内で入力してください',
            'condition.required' => '商品の状態を選択してください',
            'categories.required' => 'カテゴリーを選択してください',
        ];
    }
}
