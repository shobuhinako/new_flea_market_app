@extends('layouts.app')

@section('css')
@endsection

@section('content')
    @if($paymentMethod === 'card')
        <form action="{{route('stripe.charge')}}" method="post">
        @csrf
        <input type="hidden" name="item_id" value="{{ $item->id }}">
        <input type="hidden" name="discounted_price" value="{{ $discountedPrice }}">
        <input type="hidden" name="coupon_id" value="{{ $couponId ?? '' }}">
        <!-- @if(isset($coupon))
            <input type="hidden" name="coupon_id" value="{{ $couponId }}">
        @else
            <input type="hidden" name="coupon_id" value="">
        @endif -->
        <script
            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
            data-key="{{ env('STRIPE_KEY') }}"
            data-amount="{{ round($discountedPrice) }}"
            data-name="お支払い画面"
            data-label="支払う"
            data-description="現在はデモ画面です"
            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
            data-locale="auto"
            data-currency="JPY">
        </script>
        </form>
    @elseif($paymentMethod === 'bank_transfer')
        <div id="bank-transfer-info">
            <p>以下の振込先にお振込みください。</p>
            <p>ご登録のメールアドレスに振込先情報をお送りします</p>
            <p>金融機関コード: 1234</p>
            <p>銀行名: いろは銀行</p>
            <p>支店コード: 001</p>
            <p>支店名: 中央支店</p>
            <p>口座種別: 普通</p>
            <p>口座番号: 1234567</p>
            <p>口座名義: カ）コーチテックフリマ</p>
        </div>
        <form action="{{ route('payment.sendBankTransferInfo') }}" method="post">
        @csrf
            <input type="hidden" name="item_id" value="{{ $item->id }}">
            <input type="hidden" name="discounted_price" value="{{ $discountedPrice }}">
            <input type="hidden" name="coupon_id" value="{{ $couponId ?? '' }}">
            <!-- @if(isset($coupon))
                <input type="hidden" name="coupon_id" value="{{ $couponId }}">
            @else
                <input type="hidden" name="coupon_id" value="">
            @endif -->
            <button type="submit" class="btn btn-primary">購入する</button>
        </form>
    @endif
@endsection