@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/comment.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
    @if(session()->has('success'))
        <p>{{ session('success') }}</p>
    @endif

    <div class="item__container">
        <div class="item__image">
            <img class="item__image-content" src="{{ Storage::url('images/' . $item->image_path) }}" alt="{{ $item->name }}">
        </div>

        <div class="item__detail">
            <h2 class="item__name">{{ $item->name }}</h2>
            @if($item->brand)
                <div class="brand__name">ブランド：{{ $item->brand }}</div>
            @endif
            <div class="price">￥{{ $item->price }}(値段)</div>

            <div class="favorite">
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
                    <form class="comment__content" action="" method="get">
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

            <div class="comment__section">
                @foreach($item->comments as $comment)
                    <div class="comment @if($comment->user_id === Auth::id()) comment--right @else comment--left @endif">
                        <div class="user__info">
                            @if($comment->user->image_path)
                                <img class="user__image" src="{{ Storage::url('images/' . $comment->user->image_path) }}">
                            @else
                                <div class="user__image-alt"></div>
                            @endif
                        </div>
                        <div class="comment__details">
                            <p class="user__name">{{ $comment->user->name }}</p>
                            <p>{{ $comment->content }}</p>
                        </div>
                    </div>
                        @if($comment->user_id === Auth::id())
                            <form class="delete__button" action="{{ route('delete.comment', ['item_id' => $comment->item_id, $comment->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                                <button type="submit" class="delete__button-item">削除</button>
                            </form>
                        @endif
                @endforeach
            </div>


            <div class="comment__form">
                <div class="comment__form-label">商品へのコメント</div>
                <form class="comment__form-content" action="{{ route('create.comment', ['item_id' => $item->id]) }}" method="post">
                @csrf
                    <textarea class="comment__text" name="content" cols="30" rows="5"></textarea>
                    <div class="submit__button">
                        <input class="submit__button-item" type="submit" value="コメントを送信する">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection