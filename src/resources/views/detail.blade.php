@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
    <div class="item__image">
        <img class="item__image-content" src="{{ Storage::url('images/' . $item->image_path) }}" alt="{{ $item->name }}">
    </div>

    <div class="item__detail">
        <h2 class="item__name">{{ $item->name }}</h2>
        @if($item->brand)
            <div class="brand__name">{{ $item->brand }}</div>
        @endif
        <div class="price">￥{{ $item->price }}(値段)</div>
        @if($item->isSoldOut())
            <p class="card-text text-danger">売り切れ</p>
        @endif

        <div class="favorite">
            @auth
            <form class="favorite__content" action="{{ route('favorite', ['id' => $item->id]) }}" method="post">
            @csrf
                <button class="favorite__button" type="submit">
                    @if($item->isFavoritedBy(Auth::user()))
                        <i class="fa-solid fa-star" style="color: #ec0426;"></i>
                    @else
                        <i class="fa-solid fa-star" style="color: #a7a0a1;"></i>
                    @endif
                </button>
            </form>
            @else
            <a href="{{ route('show.login') }}" class="favorite__button">
                <i class="fa-solid fa-star" style="color: #a7a0a1;"></i>
            </a>
            @endauth
        </div>

        <div class="comment">
            @auth
            <form class="comment__content" action="{{ route('show.comment', ['item_id' => $item->id]) }}" method="get">
            @csrf
                <button class="comment__button" type="submit">
                    <i class="fa-regular fa-comment"></i>
                </button>
            </form>
            @else
            <a href="{{ route('show.login') }}" class="favorite__button">
                <i class="fa-regular fa-comment"></i>
            </a>
            @endauth
        </div>

        @if($item->isSoldOut())
            <button class="purchase__button" disabled style="background-color: grey; cursor: not-allowed;">購入する</button>
        @else
            <form class="purchase__button" action="{{ route('show.purchase', ['item_id' => $item->id]) }}" method="get">
            @csrf
                <input type="submit" value="購入する">
            </form>
        @endif

        <h3 class="item__description">商品説明</h3>
            <div class="item__description-content">
                {{ $item->description }}
            </div>
        </div>

        <h3 class="item__information">商品情報</h3>
        <table class="item__information-table">
            <tr>
                <th>カテゴリー<th>
                <td>{{ $item->category }}</td>
            </tr>
            <tr>
                <th>商品の状態</th>
                <td>{{ $item->condition }}</td>
            </tr>
        </table>
@endsection