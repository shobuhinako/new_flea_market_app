<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EditProfileRequest;
use App\Models\Item;
use App\Models\SoldItem;
use App\Mail\SendEmail;
use App\Mail\Notification;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function showMypage() {
        $user = Auth::user();

        // 出品した商品を取得
        $listedItems = Item::where('user_id', $user->id)->get();

        // 購入した商品を取得
        $purchasedItems = SoldItem::where('user_id', $user->id)->with('item')->get()->pluck('item');

        return view ('mypage', compact('user', 'listedItems', 'purchasedItems'));
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

    public function address($item_id)
    {
        return view ('address', ['item_id' => $item_id]);
    }

    public function updateAddress(Request $request)
    {
        $user = Auth::user();

        $user->post = $request->post;
        $user->address = $request->address;
        $user->building = $request->building;
        $user->save();

        return redirect()->route('show.purchase', ['item_id' => $request->item_id]);
    }

    public function showAdminMypage() {
        $user = Auth::user();

        return view ('admin-mypage', compact('user'));
    }

    public function showAdmin(){
        return view ('create-admin');
    }

    public function createAdmin(Request $request)
    {
        $form = $request->only('name', 'email', 'password');
        $user = User::create([
            'role_id' => 1,
            'name' => $form['name'],
            'email' => $form['email'],
            'password' => bcrypt($form['password']),
        ]);

        session()->flash('success_message', '管理者を作成しました。');

        return redirect('/create/admin');
    }

    public function showNotification(){
        return view('send-notification');
    }

    public function sendNotification(Request $request) {
    $destination = $request->input('destination');
    $message = $request->input('message');

    $users = collect();

    if ($destination === 'all') {
        $users = User::all();
    } elseif ($destination === 'admin') {
        $users = User::where('role_id', 1)->get();
    } elseif ($destination === 'user') {
        #rolesを持っていないuserを取得
        $users = User::whereNull('role_id')->get();
    }

    foreach ($users as $user) {
        Mail::to($user->email)->send(new SendEmail($user, $message));
    }

    return back()->with('success', 'お知らせを送信しました');
    }
}
