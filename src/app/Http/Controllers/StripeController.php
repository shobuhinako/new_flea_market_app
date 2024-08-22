<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\SoldItem;
use App\Models\Coupon;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Customer;
use Stripe\Charge;
use Illuminate\Support\Facades\Mail;
use App\Mail\BankTransferInfo;
use Illuminate\Support\Facades\Auth;

class StripeController extends Controller
{
    public function charge(Request $request)
    {
        $itemId = $request->input('item_id');
        $item = Item::findOrFail($itemId);
        $discountedPrice = $request->input('discounted_price');
        $couponId = $request->input('coupon_id', null);

        if (!$couponId) {
            $discountedPrice = $item->price;
        }

        Stripe::setApiKey(config('services.stripe.st_key'));

        $charge = Charge::create([
            'amount' => round($discountedPrice),
            'currency' => 'jpy',
            'source'=> request()->stripeToken,
        ]);

        if ($charge->status === 'succeeded') {
            SoldItem::create([
                'item_id' => $itemId,
                'user_id' => auth()->id(),
                'coupon_id' => $couponId,
                'discounted_price' => $couponId ? $discountedPrice : null,
            ]);
            return redirect()->route('payment.complete');
        } else {
            return back()->withErrors(['msg' => '支払いに失敗しました。もう一度お試しください。']);
        }
    }

    public function success()
    {
        return view ('payment-completion');
    }

    public function sendBankTransferInfo(Request $request)
    {
        $itemId = $request->input('item_id');
        $item = Item::findOrFail($itemId);
        $discountedPrice = $request->input('discounted_price');
        $couponId = $request->input('coupon_id', null);

        if ($couponId) {
            $discountedPrice = $discountedPrice;
        } else {
            $discountedPrice = $item->price;
        }

        $user = Auth::user();
        $email = $user->email;

        Mail::to($email)->send(new BankTransferInfo($item, $discountedPrice));

        // 顧客の作成または取得
        $customer = Customer::create([
            'email' => $email,
        ]);

        // 支払いインテントの作成
        Stripe::setApiKey(config('services.stripe.st_key'));

        $paymentIntent = PaymentIntent::create([
            'amount' => round($discountedPrice),
            'currency' => 'jpy',
            'payment_method_types' => ['customer_balance'],
            'customer' => $customer->id,
        ]);

        SoldItem::create([
            'item_id' => $request->input('item_id'),
            'user_id' => auth()->id(),
            'coupon_id' => $couponId,
            'discounted_price' => $couponId ? $discountedPrice : null,
        ]);

        return view('payment-completion');
    }

    public function showPaymentForm(Request $request)
    {
        $paymentMethod = $request->input('payment-method');
        $itemId = $request->input('item_id');
        $item = Item::findOrFail($itemId);
        $couponId = $request->input('coupon_id');
        $discountedPrice = $request->input('discounted_price', $item->price);

        return view('payment-form', [
            'paymentMethod' => $paymentMethod,
            'item' => $item,
            'discountedPrice' => $discountedPrice,
            'couponId' => $couponId,
        ]);
    }

}
