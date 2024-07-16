<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\SoldItem;
use App\Models\TransactionComment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Events\CommentPosted;
use App\Notifications\TransactionCompletedNotification;

class ItemController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
        $userId = auth()->id();

        // 全ての商品を取得
        $allItems = Item::all();

        // ユーザーが購入したアイテムのカテゴリを取得
        $purchasedCategories = SoldItem::where('user_id', $userId)->with('item')->get()->pluck('item.category')->unique();

        // おすすめアイテムをカテゴリから取得
        $recommendedItems = Item::whereIn('category', $purchasedCategories)->get();

        // マイリストに登録されたアイテムを取得
        $favoriteItems = Favorite::where('user_id', $userId)->with('item')->get()->pluck('item');

        } else {
            // 全商品を取得
            $allItems = Item::all();
            $recommendedItems = Item::all();
            $favoriteItems = collect(); // 空のコレクションを作成
        }

        return view('index', compact('allItems', 'recommendedItems', 'favoriteItems'));
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

        $form = $request->only('category', 'condition', 'name', 'brand', 'description', 'price');
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
        $user = Auth::user();
        $item = Item::findOrFail($item_id);

        return view ('purchase', [
            'item' => $item,
            'post' => $user->post,
            'address' => $user->address,
            'building' => $user->building,
        ]);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('search-box');

        // 検索クエリを実行
        $searchResults = Item::where('name', 'like', '%' . $keyword . '%')
            ->orWhere('description', 'like', '%' . $keyword . '%')
            ->orWhere('brand', 'like', '%' . $keyword . '%')
            ->get();

        // セッションに検索結果とキーワードを保存
        session()->flash('searchResults', $searchResults);
        session()->flash('keyword', $keyword);

        return redirect()->route('index');
    }

    public function showTransactionStatus ($item_id)
    {
        $soldItems = SoldItem::with(['user'])->findOrFail($item_id);
        $item = Item::with(['soldItems.user', 'user'])->findOrFail($item_id);
        $comments = TransactionComment::where('item_id', $item_id)->with('user')->get();
        // $transaction = TransactionComment::where('item_id', $item_id)->first();

        return view ('transaction-status', compact('item', 'comments', 'soldItems'));
    }

    public function storeTransactionComment(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:500',
            'item_id' => 'required|exists:items,id',
        ]);

        $transaction = SoldItem::where('item_id', $request->item_id)->firstOrFail();

        $comment = TransactionComment::create([
            'user_id' => Auth::id(),
            'item_id' => $request->item_id,
            'transaction_id' => $transaction->id,
            'content' => $request->content,
        ]);

        // コメントが投稿されたことを通知するイベントを発火
        event(new CommentPosted($comment));

        return back()->with('success', 'コメントが送信されました。');
    }

    public function completeTransaction(Request $request, $item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();

        $soldItem = SoldItem::where('item_id', $item_id)->firstOrFail();

        if ($user->id == $item->user_id) {
            $soldItem->is_completed_by_seller = true;
            $notificationUser = $soldItem->user;
        } else {
            $soldItem->is_completed_by_buyer = true;
            $notificationUser = $item->user;
        }

        $soldItem->save();

        $notificationUser->notify(new TransactionCompletedNotification($user));

        return back()->with('success', '取引完了が通知されました');
    }



}
