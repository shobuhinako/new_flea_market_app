<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCouponRequest extends FormRequest
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
            'discount' => 'required|integer|min:1|max:100',
            'expires_at' => 'required|after_or_equal:today',
        ];
    }

    public function messages()
    {
        return [
            'discount.required' => '割引率は必須です。',
            'discount.integer' => '割引率は整数でなければなりません。',
            'discount.min' => '割引率は1以上でなければなりません。',
            'discount.max' => '割引率は100以下でなければなりません。',
            'expires_at.after_or_equal' => '有効期限は今日以降の日付でなければなりません。',
        ];
    }
}
