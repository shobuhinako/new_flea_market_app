@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
    <div class="profile__image">
        <img class="rounded__image" src="{{ Storage::url('images/' . $user->image_path) }}" alt="プロフィール画像" />
    </div>
    <div class="top__content">
        {{ $user->name }}
        @if(Auth::user()->is_power_seller)
            <span class="power__seller-tag">
                パワーセラー
                <span class="info-icon" id="info-icon">?</span>
                <div class="info-popup" id="info-popup">
                    あなたは評価が3.5以上の出品者です。
                </div>
            </span>
        @endif
    </div>
    <form class="edit__profile" action="{{ route('show.profile') }}" method="get">
    @csrf
        <button class="edit__profile-button">プロフィールを編集</button>
    </form>
    <form class="coupon__list" action="{{ route('show.coupon.list') }}" action="get">
        @csrf
            <input type="submit" value="クーポン一覧">
    </form>

    <div class="tabs">
        <button class="tablinks" onclick="openTab(event, 'listed__items')" id="defaultOpen">出品した商品</button>
        <button class="tablinks" onclick="openTab(event, 'purchased__items')">購入した商品</button>
    </div>

    <div id="listed__items" class="tabcontent">
    <!-- 出品した商品を表示する部分 -->
        @foreach($listedItems as $item)
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <a href="{{ route('item.detail', $item->id) }}">
                        <img class="card-img-top" src="{{ Storage::url('images/' . $item->image_path) }}" alt="{{ $item->name }}">
                    </a>
                    <div class="card-body">
                        <p class="card-text">{{ $item->name }}</p>
                        <p class="card-text">{{ $item->price }}円</p>
                    </div>
                </div>
            </div>

            @if($item->is_sold) <!-- 商品が売り切れている場合 -->
                <div class="confirm__transaction-status">
                    <form class="transaction__status" action="{{ route('show.transaction.status', ['item_id' => $item->id]) }}" method="get">
                    @csrf
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        <input type="submit" value="取引状況確認">
                    </form>
                </div>
            @endif
        @endforeach
    </div>

    <div id="purchased__items" class="tabcontent">
    <!-- 購入した商品を表示する部分 -->
        @foreach($purchasedItems as $item)
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <a href="{{ route('item.detail', $item->id) }}">
                        <img class="card-img-top" src="{{ Storage::url('images/' . $item->image_path) }}" alt="{{ $item->name }}">
                    </a>
                    <div class="card-body">
                        <p class="card-text">{{ $item->name }}</p>
                        <p class="card-text">{{ $item->price }}円</p>
                    </div>
                </div>
            </div>
            <div class="confirm__transaction-status">
                <form class="transaction__status" action="{{ route('show.transaction.status', ['item_id' => $item->id]) }}" method="get">
                @csrf
                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                    <input type="submit" value="取引状況確認">
                </form>
            </div>
        @endforeach
    </div>

    <script src="{{ asset('js/mypage-script.js') }}"></script>
@endsection