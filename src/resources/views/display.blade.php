@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/display.css') }}">
@endsection

@section('content')
<div class="top__content">商品の出品</div>

@if(session()->has('success'))
    <p>{{ session('success') }}</p>
@endif

@if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<form class="display__item" action="{{ route('create.item') }}" method="post" enctype="multipart/form-data">
@csrf
    <div class="upload__image">
        <div class="upload__image-label">商品画像</div>
            <img class="item__image" src="" alt="アイテム画像">
        <div class="file-input-wrapper">
            <label class="custom-file-label" for="form-image">画像を選択する</label>
            <input type="file" id="form-image" name="image" />
        </div>
        <div class="file-name" id="file-name"></div>
    </div>

    <div class="item__detail">
        <p class="item__detail-label">商品の詳細</p>
        <div class="item__category">
            <label>カテゴリー</label>
            <select name="category" id="category" required>
                <option value="">選択してください</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : ''}}>
                        {{ $category->name}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="item__condition">
            <label>商品の状態</label>
            <select name="condition" id="condition" required>
                <option value="">選択してください</option>
                @foreach($conditions as $condition)
                    <option value="{{ $condition->id }}" {{ old('condition') == $condition->id ? 'selected' : '' }}>
                        {{ $condition->name}}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="item__description">
        <p class="item__description-label">商品名と説明</p>
        <div class="item__name">
            <label>商品名<input type="text" name="name" /></label>
        </div>
        <div class="brand__name">
            <label>ブランド<input type="text" name="brand" /></label>
        </div>
        <div class="item__description-content">
            <label>商品の説明<input type="textarea" name="description" /></label>
        </div>
    </div>

    <div class="item__price">
        <div class="item__price-content">
            <label>販売価格<input class="price-input" type="number" name="price" /></label>
        </div>
    </div>

    <div class="submit__button">
        <input type="submit" value="出品する" />
    </div>
</form>

<script src="{{ asset('js/display-script.js') }}"></script>
@endsection