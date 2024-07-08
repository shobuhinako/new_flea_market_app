@extends('layouts.app')

@section('css')
@endsection

@section('content')
    <div class="tabs">
        <button class="tablinks" onclick="openTab(event, 'allItems')" id="defaultOpen">全て</button>
        @if(Auth::check())
            <button class="tablinks" onclick="openTab(event, 'recommendations')" id="defaultOpen">おすすめ</button>
            <button class="tablinks" onclick="openTab(event, 'mylist')">マイリスト</button>
        @endif
    </div>

    @if(session('searchResults'))
        <div class="search-results">
            <h2>検索結果: "{{ session('keyword') }}"</h2>
            @if(session('searchResults')->isEmpty())
                <p>該当する商品が見つかりませんでした。</p>
            @else
                <div class="item-list">
                    @foreach(session('searchResults') as $item)
                        <div class="col-md-4">
                            <div class="card mb-4 shadow-sm">
                                <a href="{{ route('item.detail', $item->id) }}">
                                    <img class="card-img-top" src="{{ Storage::url('images/' . $item->image_path) }}" alt="{{ $item->name }}">
                                </a>
                                <div class="card-body">
                                    <p class="card-text">{{ $item->name }}</p>
                                    <p class="card-text">{{ $item->price }}円</p>
                                    @if($item->isSoldOut())
                                        <p class="card-text text-danger">売り切れ</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @else

        <div id="allItems" class="tabcontent">
            <!-- 全ての商品を表示する部分 -->
            @foreach($allItems as $item)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <a href="{{ route('item.detail', $item->id) }}">
                            <img class="card-img-top" src="{{ Storage::url('images/' . $item->image_path) }}" alt="{{ $item->name }}">
                        </a>
                        <div class="card-body">
                            <p class="card-text">{{ $item->name }}</p>
                            <p class="card-text">{{ $item->price }}円</p>
                            @if($item->isSoldOut())
                                <p class="card-text text-danger">売り切れ</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if(Auth::check())
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
                                @if($item->isSoldOut())
                                    <p class="card-text text-danger">売り切れ</p>
                                @endif
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
                                @if($item->isSoldOut())
                                    <p class="card-text text-danger">売り切れ</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif

    <script src="{{ asset('js/index-script.js') }}"></script>
@endsection