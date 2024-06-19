<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showMypage() {
        return view ('mypage');
    }

    public function showProfile() {
        return view ('profile');
    }
}
