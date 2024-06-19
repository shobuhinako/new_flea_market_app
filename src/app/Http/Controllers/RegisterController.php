<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view ('/auth/register');
    }

    public function create(RegisterRequest $request)
    {
        $form = $request->only('name', 'email', 'password');
        $user = User::create([
            'name' => $form['name'],
            'email' => $form['email'],
            'password' => bcrypt($form['password']),
        ]);

        session()->flash('success_message', '会員登録が完了しました');

        return redirect('/register');
    }

}
