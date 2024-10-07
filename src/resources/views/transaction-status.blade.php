@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/transaction-status.css') }}">
@endsection

@section('content')
    @if(session()->has('success'))
        <p>{{ session('success') }}</p>
    @endif

    <div class="transaction">
        <div class="transaction__left">
            <div class="item__image">
                <img class="item__image-content" src="{{ Storage::url('images/' . $item->image_path) }}" alt="{{ $item->name }}">
            </div>

            <div class="item__detail">
                <table class="item__detail-content">
                    <tr class="table__row">
                        <th class="table__item-name">商品名</th>
                        <td class="table__item">{{ $item->name }}</td>
                    </tr>
                    <tr class="table__row">
                        <th class="table__item-name">商品代金</th>
                        <td class="table__item">￥{{ $item->price }}</td>
                    </tr>
                    <tr class="table__row">
                        <th class="table__item-name">支払い金額</th>
                        <td class="table__item">
                            @if ($discountedPrice)
                                ￥{{ $discountedPrice }}
                            @else
                                ￥{{ $item->price }}
                            @endif
                        </td>
                    </tr>
                    <tr class="table__row">
                        <th class="table__item-name">
                            @if(Auth::user()->id == $item->user_id)
                                購入者
                            @else
                                出品者
                            @endif
                        </th>
                        <td class="table__item">
                            @if(Auth::user()->id == $item->user_id)
                                {{ $soldItem->user->name }}
                            @else
                                {{ $item->user->name }}
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="transaction__right">
            <div class="transaction__comment">
                <div class="transaction__comment-title">取引コメント</div>
                @foreach($comments as $comment)
                    <div class="comment">
                        <p>{{ $comment->user->name }}: {{ $comment->content }}</p>
                    </div>
                @endforeach

                <form class="transaction__comment-content" action="{{ route('store.transaction.comment') }}" method="post">
                @csrf
                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                    <textarea name="content" cols="40" rows="8"></textarea>
                        <div class="submit__button">
                            <input class="comment__submit" type="submit" value="取引コメントを送信する">
                        </div>
                </form>
            </div>

            <div class="transaction__complete">
                <form class="transaction__complete-submit" action="{{ route('show.transaction.rate', $item->id) }}" method="get">
                @csrf
                    @if(Auth::user()->id == $item->user_id)
                        <input class="transaction__complete-button" type="submit" value="取引完了" @if($soldItem->is_completed_by_seller) disabled @endif />
                    @else
                        <input class="transaction__complete-button" type="submit" value="取引完了" @if ($soldItem->is_completed_by_buyer) disabled @endif />
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection