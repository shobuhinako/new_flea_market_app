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
use Illuminate\Support\Facades\Cache;
use App\Models\Category;
use App\Models\Condition;
use App\Http\Requests\CompleteTransactionRequest;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::query();

        // カテゴリフィルタリング
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category_id', $request->category);
        }

        // 並び替え
        if ($request->has('sort') && !empty($request->sort)) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
            }
        }

        // 販売状況
        if ($request->has('status') && $request->status != '') {
            if ($request->status == 'available') {
                $query->whereDoesntHave('soldItems');
            } elseif ($request->status == 'sold_out') {
                $query->whereHas('soldItems');
            }
        }

        // 全ての商品を取得
        $allItems = $query->get();

        if (Auth::check()) {
            $userId = auth()->id();

            // ユーザーが購入したアイテムのカテゴリを取得
            $purchasedCategories = SoldItem::where('user_id', $userId)->with('item')->get()->pluck('item.category_id')->unique();

            // おすすめアイテムをカテゴリから取得
            $recommendedItems = Item::whereIn('category_id', $purchasedCategories)->get();

            // マイリストに登録されたアイテムを取得
            $favoriteItems = Favorite::where('user_id', $userId)->with('item')->get()->pluck('item');

        } else {
            $favoriteItems = collect(); // 空のコレクションを作成
            $viewedItems = Cache::get('viewed_items', collect());
            $recommendedItems = $viewedItems;
        }

        $categories = Category::all()->pluck('name', 'id'); // 全てのカテゴリを取得

        return view('index', compact('allItems', 'recommendedItems', 'favoriteItems', 'categories'));
    }

    public function show($id)
    {
        $item = Item::with(['category', 'condition'])->findOrFail($id);

       // ユーザーがログインしていない場合にのみキャッシュに保存する
        if (!Auth::check()) {
            // ユーザーが閲覧した商品を取得
            $viewedItems = Cache::get('viewed_items', collect());

            // 新しい商品を追加
            $viewedItems->push($item);

            // キャッシュに保存 (有効期限を設定)
            Cache::put('viewed_items', $viewedItems, 60 * 60); // 1 hour expiration
    }
        return view('detail', compact('item'));
    }

    public function showDisplayItem()
    {
        $categories = Category::all();
        $conditions = Condition::all();

        return view ('display', compact('categories', 'conditions'));
    }

    public function store(Request $request) {
        $user = Auth::user();

        $imageName = $user->id . '_image' . time() . '.' . $request->file('image')->extension();
        $request->file('image')->storeAs('public/images', $imageName);

        $form = [
        'category_id' => $request->category,
        'condition_id' => $request->condition,
        'name' => $request->name,
        'brand' => $request->brand,
        'description' => $request->description,
        'price' => $request->price,
        'image_path' => $imageName,
        'user_id' => $user->id,
        ];


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

    // public function showPurchaseForm($itemId)
    // {
    //     $item = Item::findOrFail($itemId);
    //     $discountedPrice = session('discountedPrice', $item->price);
    //     $couponCode = session('couponCode', null);
    //     $post = session('post', null);
    //     $address = session('address', null);
    //     $building = session('building', null);

    //     return view('purchase', [
    //         'item' => $item,
    //         'discountedPrice' => $discountedPrice,
    //         'couponCode' => $couponCode,
    //         'post' => $post,
    //         'address' => $address,
    //         'building' => $building,
    //     ]);
    // }

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
        $soldItem = SoldItem::with(['user'])->where('item_id', $item_id)->firstOrFail();
        $item = Item::with('user')->findOrFail($item_id);
        $comments = TransactionComment::where('item_id', $item_id)->with('user')->get();

        $discountedPrice = $soldItem->discounted_price ?? null;

        return view ('transaction-status', compact('item', 'comments', 'soldItem', 'discountedPrice'));
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

    public function completeTransaction(CompleteTransactionRequest $request, $item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();

        $soldItem = SoldItem::where('item_id', $item_id)->firstOrFail();

        if ($user->id == $item->user_id) {
            $soldItem->rating_by_seller = $request->input('point');
            $soldItem->is_completed_by_seller = true;
            $notificationUser = $soldItem->user;
        } else {
            $soldItem->rating_by_buyer = $request->input('point');
            $soldItem->is_completed_by_buyer = true;
            $notificationUser = $item->user;
        }

        $soldItem->save();

        $notificationUser->notify(new TransactionCompletedNotification($user));

        return back()->with('success', '取引完了が通知されました');
    }

    public function showRemittanceAmount()
    {
        $soldItems = SoldItem::with(['item.user'])->get();

        return view('remittance-amount-confirmation', compact('soldItems'));
    }

    public function showTransactionRate($item_id){
        $item = Item::findOrFail($item_id);
        $soldItem = SoldItem::where('item_id', $item_id)->firstOrFail();

        return view('transaction-rate', [
            'item' => $item,
            'soldItem' => $soldItem,
        ]);
    }


}
