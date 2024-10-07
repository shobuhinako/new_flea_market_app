@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('js')
    <script src="{{ asset('js/detail-script.js') }}"></script>
@endsection

@section('content')
    <div class="item__container">
        <div class="item__image">
            <img class="item__image-content" src="{{ Storage::url('images/' . $item->image_path) }}" alt="{{ $item->name }}">
        </div>

        <div class="item__detail">
            <h2 class="item__name">{{ $item->name }}</h2>
            @if($item->brand)
                <div class="brand__name">ブランド：{{ $item->brand }}</div>
            @endif
            <div class="seller__name">
                出品者：{{ $item->seller->name }}
                @if ($item->seller->is_power_seller)
                    <span class="power__seller-tag">
                        パワーセラー
                        <span class="info-icon" id="info-icon">?</span>
                        <div class="info-popup" id="info-popup">
                            パワーセラーは、評価が3.5以上の出品者です。
                        </div>
                    </span>
                @endif
            </div>
            <div class="price">￥{{ $item->price }}(値段)</div>
            @if($item->isSoldOut())
                <p class="card-text text-danger">売り切れ</p>
            @endif

            <div class="favorite__comment">
                <div class="favorite__section">
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
                    <div class="favorite__count">{{ $item->favoritedBy->count() }}</div>
                </div>

                <div class="comment__area">
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
                    <div class="comment__count">{{ $item->comments->count() }}</div>
                </div>
            </div>

            <div class="purchase">
                @if($item->isSoldOut())
                    <button class="purchase__button" disabled style="background-color: gray; cursor: not-allowed;">購入する</button>
                @else
                    <form action="{{ route('show.purchase', ['item_id' => $item->id]) }}" method="get">
                    @csrf
                        <input class="purchase__button-item" type="submit" value="購入する">
                    </form>
                @endif
            </div>

            <h3 class="item__description">商品説明</h3>
            <div class="item__description-content">
                {{ $item->description }}
            </div>

            <h3 class="item__information">商品情報</h3>
            <table class="item__information-table">
                <tr>
                    <th>カテゴリー</th>
                    <td>{{ $item->category->name }}</td>
                </tr>
                <tr>
                    <th>商品の状態</th>
                    <td>{{ $item->condition->name }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection