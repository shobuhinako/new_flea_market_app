@extends('layouts.app')

@section('css')
@endsection

@section('content')
    <div class="header__menu">
        <div class="header__menu-item">おすすめ</div>
        <div class="header__menu-item">マイリスト</div>
    </div>

    <div class="container">
        <div class="row">
            @foreach($items as $item)
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
            @endforeach
        </div>
    </div>
@endsection