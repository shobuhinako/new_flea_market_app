<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view ('index', ['items' => $items]);
    }

    public function show($id)
    {
        $item = Item::findOrFail($id);
        return view('detail', compact('item'));
    }

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

    public function showComment($item_id)
    {
        $item = Item::with('comments.user')->findOrFail($item_id);
        return view ('comment', compact('item_id', 'item'));
    }

    public function create (Request $request, $item_id)
    {
        $user = Auth::user();

        Comment::create([
            'user_id' => $user->id,
            'item_id' => $item_id,
            'content' => $request->input('content'),
        ]);

        return back()->with('success', 'コメントが追加されました。');
    }

    public function destroy (Request $request, $item_id, $comment_id)
    {
        $comment = Comment::where('id', $comment_id)->first();
        if ($comment) {
            $comment->delete();
        }
        return redirect()->back()->with('success', 'コメントを削除しました。');
    }

    public function showPurchaseForm ($item_id)
    {
        $item = Item::findOrFail($item_id);

        return view ('purchase', compact('item', 'item_id'));
    }
}
