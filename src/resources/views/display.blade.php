@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/display.css') }}">
@endsection

@section('content')
<div class="top__content">商品の出品</div>

@if(session()->has('success'))
    <p>{{ session('success') }}</p>
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
                <option value="ファッション" {{ old('category') == 'ファッション' ? 'selected' : '' }}>ファッション</option>
                <option value="ベビー・キッズ" {{ old('category') == 'ベビー・キッズ' ? 'selected' : '' }}>ベビー・キッズ</option>
                <option value="ゲーム・おもちゃ・グッズ" {{ old('category') == 'ゲーム・おもちゃ・グッズ' ? 'selected' : '' }}>ゲーム・おもちゃ・グッズ</option>
                <option value="ホビー・楽器・アート" {{ old('category') == 'ホビー・楽器・アート' ? 'selected' : '' }}>ホビー・楽器・アート</option>
                <option value="チケット" {{ old('category') == 'チケット' ? 'selected' : '' }}>チケット</option>
                <option value="本・雑誌・漫画" {{ old('category') == '本・雑誌・漫' ? 'selected' : '' }}>本・雑誌・漫</option>
                <option value="CD・DVD・ブルーレイ" {{ old('category') == 'CD・DVD・ブルーレイ' ? 'selected' : '' }}>CD・DVD・ブルーレイ</option>
                <option value="スマホ・タブレット・パソコン" {{ old('category') == 'スマホ・タブレット・パソコン' ? 'selected' : '' }}>スマホ・タブレット・パソコン</option>
                <option value="テレビ・オーディオ・カメラ" {{ old('category') == 'テレビ・オーディオ・カメラ' ? 'selected' : '' }}>テレビ・オーディオ・カメラ</option>
                <option value="生活家電・空調" {{ old('category') == '生活家電・空調' ? 'selected' : '' }}>生活家電・空調</option>
                <option value="スポーツ" {{ old('category') == 'スポーツ' ? 'selected' : '' }}>スポーツ</option>
                <option value="アウトドア・釣り・旅行用品" {{ old('category') == 'アウトドア・釣り・旅行用品' ? 'selected' : '' }}>アウトドア・釣り・旅行用品</option>
                <option value="コスメ・美容" {{ old('category') == 'コスメ・美容' ? 'selected' : '' }}>コスメ・美容</option>
                <option value="ダイエット・健康" {{ old('category') == 'ダイエット・健康' ? 'selected' : '' }}>ダイエット・健康</option>
                <option value="食品・飲料・酒" {{ old('category') == '食品・飲料・酒' ? 'selected' : '' }}>食品・飲料・酒</option>
                <option value="キッチン・日用品・その他" {{ old('category') == 'キッチン・日用品・その他' ? 'selected' : '' }}>キッチン・日用品・その他</option>
                <option value="家具・インテリア" {{ old('category') == '家具・インテリア' ? 'selected' : '' }}>家具・インテリア</option>
                <option value="ペット用品" {{ old('category') == 'ペット用品' ? 'selected' : '' }}>ペット用品</option>
                <option value="DIY・工具" {{ old('category') == 'DIY・工具' ? 'selected' : '' }}>DIY・工具</option>
                <option value="フラワー・ガーデニング" {{ old('category') == 'フラワー・ガーデニング' ? 'selected' : '' }}>フラワー・ガーデニング</option>
                <option value="ハンドメイド・手芸" {{ old('category') == 'ハンドメイド・手芸' ? 'selected' : '' }}>ハンドメイド・手芸</option>
                <option value="車・バイク・自転車" {{ old('category') == '車・バイク・自転車' ? 'selected' : '' }}>車・バイク・自転車</option>
            </select>
        </div>
        <div class="item__condition">
            <label>商品の状態</label>
            <select name="condition" id="condition" required>
                <option value="">選択してください</option>
                <option value="新品" {{ old('condition') == '新品' ? 'selected' : '' }}>新品</option>
                <option value="未使用に近い" {{ old('condition') == '未使用に近い' ? 'selected' : '' }}>未使用に近い</option>
                <option value="目立った傷や汚れなし" {{ old('condition') == '目立った傷や汚れなし' ? 'selected' : '' }}>目立った傷や汚れなし</option>
                <option value="やや傷や汚れあり" {{ old('condition') == 'やや傷や汚れあり' ? 'selected' : '' }}>やや傷や汚れあり</option>
                <option value="傷や汚れあり" {{ old('condition') == '傷や汚れあり' ? 'selected' : '' }}>傷や汚れあり</option>
                <option value="全体的に状態が悪い" {{ old('condition') == '全体的に状態が悪い' ? 'selected' : '' }}>全体的に状態が悪い</option>
            </select>
        </div>
    </div>

    <div class="item__description">
        <p class="item__description-label">商品名と説明</p>
        <div class="item__name">
            <label>商品名<input type="text" name="name" /></label>
        </div>
        <div class="item__description-content">
            <label>商品の説明<input type="textarea" name="description" /></label>
        </div>
    </div>

    <div class="item__price">
        <p class="item__price-label">販売価格</p>
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