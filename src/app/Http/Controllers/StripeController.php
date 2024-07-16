<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\SoldItem;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Customer;
use Stripe\Charge;
use Illuminate\Support\Facades\Mail;
use App\Mail\BankTransferInfo;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;
use Illuminate\Support\Facades\Auth;

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

        Stripe::setApiKey(config('services.stripe.st_key'));

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

    public function sendBankTransferInfo(Request $request)
    {
        $itemId = $request->input('item_id');
        $item = Item::findOrFail($itemId);

        $user = Auth::user();
        $email = $user->email;

        Mail::to($email)->send(new BankTransferInfo($item));

        // 顧客の作成または取得
        $customer = Customer::create([
            'email' => $email,
        ]);

        // 支払いインテントの作成
        Stripe::setApiKey(config('services.stripe.st_key'));

        $paymentIntent = PaymentIntent::create([
            'amount' => $item->price,
            'currency' => 'jpy',
            'payment_method_types' => ['customer_balance'],
            'customer' => $customer->id,
        ]);

        SoldItem::create([
            'item_id' => $request->input('item_id'),
            'user_id' => auth()->id(),
        ]);

        return view('payment-completion');
    }

    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = Webhook::constructEvent(
                $payload, $sigHeader, $endpointSecret
            );
        } catch (SignatureVerificationException $e) {
            Log::error('Stripe webhook signature verification failed.', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        switch ($event['type']) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event['data']['object'];
                // 成功時の処理
                Log::info('PaymentIntent succeeded', ['payment_intent' => $paymentIntent]);
                break;
            case 'payment_intent.payment_failed':
                $paymentIntent = $event['data']['object'];
                // 失敗時の処理
                Log::warning('PaymentIntent failed', ['payment_intent' => $paymentIntent]);
                break;
            default:
                Log::info('Received unknown event type', ['event' => $event]);
                break;
        }

        return response()->json(['status' => 'success'], 200);
    }
}
