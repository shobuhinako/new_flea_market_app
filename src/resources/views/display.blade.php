@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/display.css') }}">
@endsection

@section('content')
<div class="top__content">
    <h2 class="top__content-item">商品の出品</h2>
</div>

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
    <div class="upload__image-label">商品画像</div>
    <div class="upload__image">
        <img class="item__image" id="item-image-preview" src="" />

        <div class="file-input-wrapper">
            <label class="custom-file-label" for="form-image">画像を選択する</label>
            <input type="file" id="form-image" name="image" style="display: none;"/>
        </div>

    </div>

    <div class="item__detail">
        <h3 class="item__detail-label">商品の詳細</h3>
        <div class="line"></div>
        <div class="item__category">
            <label class="label">カテゴリー</label></br>
            <select class="category" name="category" id="category" required>
                <option value="">選択してください</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : ''}}>
                        {{ $category->name}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="item__condition">
            <label class="label" >商品の状態</label></br>
            <select class="condition" name="condition" id="condition" required>
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
        <h3 class="item__description-label">商品名と説明</h3>
        <div class="line"></div>
        <div class="item__name">
            <label class="label">商品名</label></br>
            <input class="text__box" type="text" name="name" />
        </div>
        <div class="brand__name">
            <label class="label">ブランド</label></br>
            <input class="text__box" type="text" name="brand" />
        </div>
        <div class="item__description-content">
            <label class="label">商品の説明</label></br>
            <textarea class="text__area" rows="8" cols="39" name="description"></textarea>
        </div>
    </div>

    <div class="item__price">
        <div class="item__price-content">
            <label class="label">販売価格</label></br>
            <input class="price-input" type="number" name="price" />
        </div>
    </div>

    <div class="submit__button">
        <input class="submit__button-item" type="submit" value="出品する" />
    </div>
</form>

<script src="{{ asset('js/display-script.js') }}"></script>
@endsection