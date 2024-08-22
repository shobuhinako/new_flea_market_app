@extends('layouts.app')

@section('css')
@endsection

@section('content')
    @if(session()->has('success'))
        <p>{{ session('success') }}</p>
    @endif

    <div class="item__information">
        <div class="item__image">
            <img class="item__image-content" src="{{ Storage::url('images/' . $item->image_path) }}" alt="{{ $item->name }}">
        </div>
        <h2 class="item__name">{{ $item->name }}</h2>
        <div class="item__price">￥{{ $item->price }}</div>
        <div class="payment">

        <h3 class="shipping__address">配送先</h3>
        @if ($post && $address)
            <div class="address__details">
                <p>〒{{ $post }}</p>
                <p>{{ $address }}</p>
                @if ($building)
                    <p>{{ $building }}</p>
                @endif
                <form class="shipping__address-change" action="{{ route('show.address', ['item_id' => $item->id]) }}" method="get">
                @csrf
                    <input type="submit" name="link" value="変更する">
                </form>
            </div>
        @else
            <div class="address__registration">
                <p>配送先が登録されていません。配送先を登録してください。</p>
                <form class="shipping__address-change" action="{{ route('show.address', ['item_id' => $item->id]) }}" method="get">
                @csrf
                    <input type="submit" name="link" value="変更する">
                </form>
            </div>
        @endif
        <input type="hidden" id="user-post" value="{{ $post }}">
        <input type="hidden" id="user-address" value="{{ $address }}">

        <div class="coupon__section">
            <h3>クーポンコード</h3>
            <form action="{{ route('apply.coupon') }}" method="post">
            @csrf
                <input type="hidden" name="item_id" value="{{ $item->id }}">
                <input type="text" id="coupon-code" name="coupon_code" placeholder="クーポンコードを入力">
                <button type="submit">適用</button>
            </form>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('coupon_id'))
                <form action="{{ route('clear.coupon') }}" method="post">
                    @csrf
                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                    <button type="submit">クーポンをクリア</button>
                </form>
            @endif
        </div>

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
    </div>

    <div class="purchase__confirmation">
        <form id="payment-method-form" action="{{ route('show.payment.form') }}" method="get">
        @csrf
            <input type="hidden" name="payment-method" id="hidden-payment-method" value="card">
            <input type="hidden" name="item_id" value="{{ $item->id }}">
            <input type="hidden" name="discounted_price" value="{{ isset($discountedPrice) ? $discountedPrice : $item->price }}">
            @if(session('coupon_id'))
                <input type="hidden" name="coupon_id" value="{{ session('coupon_id') }}">
            @endif

            <div class="purchase__confirmation-content">
                <table class="purchase__content">
                    <tr class="table__row">
                        <th class="table__item-name">商品代金</th>
                        <td class="table__item">￥{{ $item->price }}</td>
                    </tr>
                    <tr class="table__row">
                        <th class="table__item-name">支払い金額</th>
                        <td class="table__item">￥{{ isset($discountedPrice) ? $discountedPrice : $item->price }}</td>
                    </tr>
                    <tr class="table__row">
                        <th class="table__item-name">支払い方法</th>
                        <td class="table__item" id="display-selected-payment-method">クレジットカード</td>
                    </tr>
                </table>
            </div>
            <button id="submit-button" @if(!$post || !$address) disabled @endif>購入する</button>
        </form>
    </div>

    <script src="{{ asset('js/purchase-script.js') }}"></script>
@endsection