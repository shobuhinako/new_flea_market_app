<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function show($id)
    {
        $item = Item::findOrFail($id);
        return view('detail', compact('item'));
    }

    public function favorite(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('show.login');
        }

        $user = Auth::user();
        $item = Item::findOrFail($id);

        if ($item->isFavoritedBy($user)) {
            $user->favorites()->detach($item->id);
        } else {
            $user->favorites()->attach($item->id);
        }

        return back();
    }
}
