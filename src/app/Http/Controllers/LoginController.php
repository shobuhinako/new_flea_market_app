<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view ('/auth/login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // ログイン成功時の処理
            $user = Auth::user();

            // セッションの再生成（セキュリティ対策）
            $request->session()->regenerate();

            // ホームページにリダイレクト
            return redirect('/');
        }

            // 認証失敗時の処理
            return back()->withErrors(['email' => '認証情報が正しくありません。'])->withInput();
    }
}
