<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateItemRequest extends FormRequest
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'category' => 'required',
            'condition' => 'required',
            'name' => 'required|string|max:40',
            'brand' => 'nullable|string|max:50',
            'description' => 'required|string',
            'price' => 'required|numeric|min:1',
        ];
    }

    public function attributes()
    {
        return [
            'image' => 'アイテム画像',
            'category' => 'カテゴリー',
            'condition' => '商品の状態',
            'name' => '商品名',
            'brand' => 'ブランド',
            'description' => '商品の説明',
            'price' => '販売価格',
        ];
    }

    public function messages()
    {
        return [
            'image.image' => '商品画像は画像ファイルでなければなりません。',
            'image.mimes' => '商品画像はjpeg, png, jpg, または gif 形式でなければなりません。',

            'category.required' => 'カテゴリーは必須です。',

            'condition.required' => '商品の状態は必須です。',

            'name.required' => '商品名は必須です。',
            'name.string' => '商品名は文字列でなければなりません。',
            'name.max' => '商品名は最大40文字でなければなりません。',

            'brand.string' => 'ブランド名は文字列でなければなりません。',
            'brand.max' => 'ブランド名は最大50文字でなければなりません。',

            'description.string' => '商品の説明は文字列でなければなりません。',

            'price.required' => '販売価格は必須です。',
            'price.numeric' => '販売価格は数値でなければなりません。',
            'price.min' => '販売価格は1以上の数値でなければなりません。',
        ];
    }
}
