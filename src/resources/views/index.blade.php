@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <div class="tabs">
        <button class="tablinks" onclick="openTab(event, 'allItems')" id="defaultOpen" data-tab="allItems">全て</button>
        @if(Auth::check())
            @if(Auth::user()->role_id != 1)
                <button class="tablinks" onclick="openTab(event, 'recommendations')" data-tab="recommendations">おすすめ</button>
                <button class="tablinks" onclick="openTab(event, 'mylist')" data-tab="mylist">マイリスト</button>
            @endif
        @else
            <button class="tablinks" onclick="openTab(event, 'recommendations')" data-tab="recommendations">おすすめ</button>
            <button class="tablinks" onclick="openTab(event, 'mylist')" data-tab="mylist">マイリスト</button>
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
                                    <div class="card__text">
                                        {{ $item->name }}
                                    </div>
                                    <div class="card__text">
                                        {{ $item->price }}円
                                    </div>
                                    @if($item->isSoldOut())
                                        <div class="card-text text-danger">売り切れ</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @else
        <form method="get" action="{{ route('index') }}" id="filterForm">
            <div class="filters">
                <label for="category">カテゴリ:</label>
                <select name="category" id="category">
                    <option value="">全て</option>
                    @foreach($categories as $id => $name)
                        <option value="{{ $id }}" {{ request('category') == $id ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>

                <label for="sort">並び替え:</label>
                <select name="sort" id="sort">
                    <option value="">選択してください</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>料金の安い順</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>料金の高い順</option>
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>新しい順</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>古い順</option>
                </select>

                <label for="status">販売状況:</label>
                <select name="status" id="status">
                    <option value="">全て</option>
                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>販売中</option>
                    <option value="sold_out" {{ request('status') == 'sold_out' ? 'selected' : '' }}>売り切れ</option>
                </select>

                <button class="filter__button" type="submit">フィルターを適用</button>
                <button class="filter__button" type="button" id="clearFilters">フィルターをクリア</button>
            </div>
        </form>

        <div class="line"></div>

        <div id="allItems" class="tabcontent">
        <!-- 全ての商品を表示する部分 -->
            <div class="container">
                <div class="row">
                    @foreach($allItems as $item)
                        <div class="col-md-4">
                            <div class="card mb-4 shadow-sm">
                                <a href="{{ route('item.detail', $item->id) }}">
                                    <img class="card-img-top" src="{{ Storage::url('images/' . $item->image_path) }}" alt="{{ $item->name }}">
                                </a>
                                <div class="card-body">
                                    <div class="card__text">
                                        {{ $item->name }}
                                    </div>
                                    <div class="card__text">
                                        {{ $item->price }}円
                                    </div>
                                    @if($item->isSoldOut())
                                        <div class="card-text text-danger">売り切れ</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div id="recommendations" class="tabcontent">
            <!-- おすすめの商品を表示する部分 -->
            @if(Auth::check())
                <div class="container">
                    <div class="row">
                        @foreach($recommendedItems as $item)
                            <div class="col-md-4">
                                <div class="card mb-4 shadow-sm">
                                    <a href="{{ route('item.detail', $item->id) }}">
                                        <img class="card-img-top" src="{{ Storage::url('images/' . $item->image_path) }}" alt="{{ $item->name }}">
                                    </a>
                                    <div class="card-body">
                                        <div class="card__text">
                                            {{ $item->name }}
                                        </div>
                                        <div class="card__text">
                                            {{ $item->price }}円
                                        </div>
                                        @if($item->isSoldOut())
                                            <div class="card-text text-danger">売り切れ</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                @if($recommendedItems->isNotEmpty())
                    <div class="container">
                        <div class="row">
                            @foreach($recommendedItems as $item)
                                <div class="col-md-4">
                                    <div class="card mb-4 shadow-sm">
                                        <a href="{{ route('item.detail', $item->id) }}">
                                            <img class="card-img-top" src="{{ Storage::url('images/' . $item->image_path) }}" alt="{{ $item->name }}">
                                        </a>
                                        <div class="card-body">
                                            <div class="card__text">
                                                {{ $item->name }}
                                            </div>
                                            <div class="card__text">
                                                {{ $item->price }}円
                                            </div>
                                            @if($item->isSoldOut())
                                                <div class="card-text text-danger">売り切れ</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <p>おすすめの商品がありません。</p>
                @endif
            @endif
        </div>

        @if(Auth::check() && Auth::user()->role_id != 1)
            <div id="mylist" class="tabcontent">
                <!-- マイリストの商品を表示する部分 -->
                <div class="container">
                    <div class="row">
                        @foreach($favoriteItems as $item)
                            <div class="col-md-4">
                                <div class="card mb-4 shadow-sm">
                                    <a href="{{ route('item.detail', $item->id) }}">
                                        <img class="card-img-top" src="{{ Storage::url('images/' . $item->image_path) }}" alt="{{ $item->name }}">
                                    </a>
                                    <div class="card-body">
                                        <div class="card__text">
                                            {{ $item->name }}
                                        </div>
                                        <div class="card__text">
                                            {{ $item->price }}円
                                        </div>
                                        @if($item->isSoldOut())
                                            <div class="card-text text-danger">売り切れ</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    @endif

    <script src="{{ asset('js/index-script.js') }}"></script>
@endsection