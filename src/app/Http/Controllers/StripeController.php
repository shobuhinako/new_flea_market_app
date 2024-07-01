<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\SoldItem;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Customer;
use Stripe\Charge;

class StripeController extends Controller
{
    // public function charge(Request $request)
    // {
    //     Stripe::setApiKey(env('STRIPE_SECRET'));

    //     $item = Item::findOrFail($request->input('item_id'));
    //     $amount = $item->price;

    //     if ($request->input('payment_method') == 'credit_card') {
    //         $paymentIntent = PaymentIntent::create([
    //             'amount' => $amount,
    //             'currency' => 'jpy',
    //             'payment_method_types' => ['card'],
    //         ]);

    //         return view('checkout.credit_card', ['paymentIntent' => $paymentIntent, 'item' => $item]);
    //     } elseif ($request->input('payment_method') == 'bank_transfer') {
    //         $paymentIntent = PaymentIntent::create([
    //             'amount' => $amount,
    //             'currency' => 'jpy',
    //             'payment_method_types' => ['bank_transfer'],
    //         ]);

    //         return view('checkout.bank_transfer', ['paymentIntent' => $paymentIntent, 'item' => $item]);
    //     }

    //     return back()->with('error', 'Invalid payment method.');
    // }

    // public function changePayment(Request $request)
    // {
    //     session(['payment_method' => 'credit_card']); // デフォルトをクレジットカードに設定
    //     return back();
    // }

    // public function updatePayment(Request $request)
    // {
    //     session(['payment_method' => $request->input('payment_method')]);
    //     return back();
    // }

    // public function createPaymentIntent(Request $request)
    // {
    //     Stripe::setApiKey(env('STRIPE_SECRET'));

    //     $item = Item::findOrFail($request->input('item_id'));
    //     $amount = $item->price;
    //     $paymentMethod = $request->input('payment_method', 'card');

    //     $customer = Customer::create();

    //     $paymentIntentData = [
    //         'customer' => $customer->id,
    //         'amount' => $amount,
    //         'currency' => 'jpy',
    //         'payment_method_types' => ['customer_balance', 'card'],
    //         ];

    //     if ($paymentMethod === 'bank_transfer') {
    //         $paymentIntentData['payment_method_options'] = [
    //             'customer_balance' => [
    //                 'funding_type' => 'bank_transfer',
    //                 'bank_transfer' => [
    //                     'type' => 'jp_bank_transfer',
    //                 ],
    //             ],
    //         ];
    //     }
    //         $paymentIntent = PaymentIntent::create($paymentIntentData);

    //     return response()->json([
    //         'clientSecret' => $paymentIntent->client_secret,
    //     ]);
    // }

    public function showPaymentForm(Request $request)
    {
        $paymentMethod = $request->input('payment-method');
        $itemId = $request->input('item_id');
        $item = Item::find($itemId);

        if (!$item) {
            return abort(404);
        }

        return view('payment-form', [
            'paymentMethod' => $paymentMethod,
            'item' => $item,
        ]);
    }

    public function charge(Request $request)
    {
        $itemId = $request->input('item_id');
        $item = Item::findOrFail($itemId);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $charge = Charge::create([
            'amount' => $item->price,
            'currency' => 'jpy',
            'source'=> request()->stripeToken,
        ]);

        if ($charge->status === 'succeeded') {
        SoldItem::create([
            'item_id' => $request->input('item_id'),
            'user_id' => auth()->id(),
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
}
