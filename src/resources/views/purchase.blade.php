@extends('layouts.app')

@section('css')
@endsection

@section('content')
    <div class="item__information">
        <div class="item__image">
            <img class="item__image-content" src="{{ Storage::url('images/' . $item->image_path) }}" alt="{{ $item->name }}">
        </div>
        <h2 class="item__name">{{ $item->name }}</h2>
        <div class="item__price">￥{{ $item->price }}</div>
        <div class="payment">
        <h3 class="payment__options">支払い方法</h3>
            <div id="selected-payment-method" class="default__option">クレジットカード</div>
            <button type="button" id="change-payment-method">変更する</button>
            <div id="payment-method-selection" style="display: none;">
                <label>
                    <input type="radio" name="payment-method" value="card" checked> クレジットカード
                </label>
                <label>
                    <input type="radio" name="payment-method" value="bank_transfer"> 銀行振込
                </label>
                <button type="button" id="confirm-payment-method">決定</button>
            </div>
        <h3 class="shipping__address">配送先</h3>
            <form class="shipping__address-change" action="{{ route('show.address') }}" method="get">
            @csrf
                <input type="submit" name="link" value="変更する">
            </form>
    </div>

    <div class="purchase__confirmation">
        <form id="payment-method-form" action="{{ route('show.payment.form') }}" method="get">
        @csrf
            <input type="hidden" name="payment-method" id="hidden-payment-method" value="card">
            <input type="hidden" name="item_id" value="{{ $item->id }}">
            <div class="purchase__confirmation-content">
                <table class="purchase__content">
                    <tr class="table__row">
                        <th class="table__item-name">商品代金</th>
                        <td class="table__item">￥{{ $item->price }}</td>
                    </tr>
                    <tr class="table__row">
                        <th class="table__item-name">支払い金額</th>
                        <td class="table__item">￥{{ $item->price }}</td>
                    </tr>
                    <tr class="table__row">
                        <th class="table__item-name">支払い方法</th>
                        <td class="table__item" id="display-selected-payment-method">クレジットカード</td>
                    </tr>
                </table>
            </div>
            <button id="submit-button">購入する</button>
        </form>
    </div>

    <script src="{{ asset('js/purchase-script.js') }}"></script>
@endsection