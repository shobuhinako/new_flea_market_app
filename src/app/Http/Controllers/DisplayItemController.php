<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;


class DisplayItemController extends Controller
{
    public function showDisplayItem()
    {
        return view ('display');
    }

    public function store(Request $request) {
        $user = Auth::user();

        $imageName = $user->id . '_image' . time() . '.' . $request->file('image')->extension();
        $request->file('image')->storeAs('public/images', $imageName);

        $form = $request->only('category', 'condition', 'name', 'description', 'price');
        $form['image_path'] = $imageName;
        $form['user_id'] = $user->id;


        $item = Item::create($form);

        return back()->with('success', '出品が完了しました。');
    }
}
