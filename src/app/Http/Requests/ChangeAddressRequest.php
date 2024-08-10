<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ValidAddress;

class ChangeAddressRequest extends FormRequest
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
            'post' => 'required|digits:7',
            'address' => ['required', 'string', 'max:50', new ValidAddress],
            'building' => 'nullable|string|max:50',
        ];
    }

    public function attributes()
    {
        return [
            'post' => '郵便番号',
            'address' => '住所',
            'building' => '建物名',
        ];
    }

    public function messages()
    {
        return [
            'post.required' => '郵便番号は必須です。',
            'post.digits' => '郵便番号は7桁の数字でなければなりません。',

            'address.required' => '住所は必須です。',
            'address.string' => '住所は文字列でなければなりません。',
            'address.max' => '住所は最大50文字でなければなりません。',

            'building.string' => '建物名は文字列でなければなりません。',
            'building.max' => '建物名は最大50文字でなければなりません。',
        ];
    }




}
