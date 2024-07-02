@extends('layouts.app')

@section('css')
@endsection

@section('content')
    <div class="tabs">
        <button class="tablinks" onclick="openTab(event, 'recommendations')" id="defaultOpen">おすすめ</button>
        <button class="tablinks" onclick="openTab(event, 'mylist')">マイリスト</button>
    </div>

    <div id="recommendations" class="tabcontent">
        <!-- おすすめの商品を表示する部分 -->
        @foreach($recommendedItems as $item)
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

    <div id="mylist" class="tabcontent">
        <!-- マイリストの商品を表示する部分 -->
        @foreach($favoriteItems as $item)
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

    <script src="{{ asset('js/index-script.js') }}"></script>
@endsection