<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ValidName;

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
            'name' => ['required', 'string', 'max:255', new ValidName],
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'ユーザー名を入力してください。',
            'name.string' => 'ユーザー名は文字列でなければなりません。',
            'name.max' => 'ユーザー名は最大255文字でなければなりません。',
            'email.required' => 'メールアドレスを入力してください。',
            'email.email' => 'メールアドレスは「ユーザー名@ドメイン」形式で入力してください。',
            'password.required' => 'パスワードを入力してください。',
            'password.min' => 'パスワードは8文字以上で設定してください。',
            'password.confirmed' => '確認用パスワードと一致しません。'
        ];
    }
}
