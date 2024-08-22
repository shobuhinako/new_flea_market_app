<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use Illuminate\Support\Str;
use App\Models\User;
use App\Mail\CouponCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Http\Requests\ApplyCouponRequest;
use App\Http\Requests\StoreCouponRequest;

class CouponController extends Controller
{
    public function showCoupon(){
        return view ('create-coupon');
    }

    public function createCoupon(StoreCouponRequest $request){
        $validated = $request->validated();

        $coupon = new Coupon();
        $coupon->code = $this->generateUniqueCode();
        $coupon->discount = $validated['discount'];
        $coupon->expires_at = $validated['expires_at'];
        $coupon->save();

        $users = User::all();
        foreach ($users as $user) {
            Mail::to($user->email)->send(new CouponCreated($coupon));
        }

        return redirect('/create/coupon')->with('success_message', 'クーポンが作成されました');
    }

    private function generateUniqueCode()
    {
        do {
            // 英字と数字の組み合わせでランダムなコードを生成
            $code = strtoupper(Str::random(10));
        } while (Coupon::where('code', $code)->exists()); // コードが既に存在するかチェック

        return $code;
    }

    public function showCouponList() {
        $user = Auth::user();
        if ($user->id == 1) {
            // 管理者はすべてのクーポンを表示
            $coupons = Coupon::all();
        } else {
            // 他のユーザーは期限が切れていないクーポンのみ表示
            $coupons = Coupon::where('expires_at', '>', now())->get();
        }

        return view('coupon-list', compact('coupons'));
    }

    public function applyCoupon(ApplyCouponRequest $request)
    {
        $couponCode = $request->input('coupon_code');
        $itemId = $request->input('item_id');
        $item = Item::findOrFail($itemId);
        $coupon = Coupon::where('code', $couponCode)->first();
        $user = Auth::user();

        $discount = $coupon->discount;
        $discountedPrice = $item->price * (1 - $discount / 100);

        session([
            'coupon_id' => $coupon->id,
            'discounted_price' => $discountedPrice,
            'original_price' => $item->price,
        ]);

        return view('purchase', [
            'item' => $item,
            'item_id' => $itemId,
            'discountedPrice' => $discountedPrice,
            'couponCode' => $couponCode,
            'post' => $user->post,
            'address' => $user->address,
            'building' => $user->building,
        ]);
    }

    public function clearCoupon(Request $request)
    {
        $originalPrice = $request->session()->get('original_price');

        $request->session()->forget('coupon_id');
        $request->session()->forget('discounted_price');

        $request->session()->put('discounted_price', $originalPrice);

        $itemId = $request->input('item_id');

        return redirect()->route('show.purchase', ['item_id' => $itemId])
            ->with('success', 'クーポンがクリアされました。');
    }
}
