@extends('layouts.app')

@section('css')
@endsection

@section('content')
    @if($paymentMethod === 'card')
        <form action="{{route('stripe.charge')}}" method="post">
        @csrf
        <input type="hidden" name="item_id" value="{{ $item->id }}">
        <script
            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
            data-key="{{ env('STRIPE_KEY') }}"
            data-amount="{{ $item->price }}"
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
            <p>金融機関コード: 1234</p>
            <p>銀行名: いろは銀行</p>
            <p>支店コード: 001</p>
            <p>支店名: 中央支店</p>
            <p>口座種別: 普通</p>
            <p>口座番号: 1234567</p>
            <p>口座名義: カ）コーチテックフリマ</p>
        </div>
    @endif
@endsection
