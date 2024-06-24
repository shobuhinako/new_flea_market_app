<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EditProfileRequest;
use App\Models\Item;

class UserController extends Controller
{
    public function showMypage() {
        $user = Auth::user();
        $items = Item::where('user_id', $user->id)->get();
        return view ('mypage', compact('user', 'items'));
    }

    public function showProfile() {
        $user = Auth::user();
        return view ('profile', compact('user'));
    }

    public function editProfile(EditProfileRequest $request) {

        $user = Auth::user();

        if ($request->filled('name')) {
            $user->name = $request->input('name');
        }

        if ($request->filled('post')) {
            $user->post = $request->input('post');
        }

        if ($request->filled('address')) {
            $user->address = $request->input('address');
        }

        if ($request->filled('building')) {
            $user->building = $request->input('building');
        }

        if ($request->hasFile('image')) {
            // 既存のアバターを削除
            if ($user->image_path) {
                Storage::delete('public/images/' . $user->image_path);
            }
            $imageName = $user->id.'_image'.time().'.'.$request->file('image')->extension();
            $request->file('image')->storeAs('public/images', $imageName);
            $user->image_path = $imageName;
        }

        $user->save();

        return back()->with('success', 'プロフィールが更新されました。');
    }
}
