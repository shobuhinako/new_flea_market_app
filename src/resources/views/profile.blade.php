@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="top__content">プロフィール設定</div>

@if(session()->has('success'))
    <p>{{ session('success') }}</p>
@endif

<form class="edit__profile" action="{{ route('edit.profile') }}" method="post" enctype="multipart/form-data">
@csrf
@method('PUT')
    <div class="profile__image">
        <img class="rounded__image" src="{{ $user->profile && $user->profile->image ? asset('storage/images/' . $user->profile->image) : '' }}" alt="プロフィール画像">
        <div class="file-input-wrapper">
            <label class="custom-file-label" for="form-image">画像を選択する</label>
            <input type="file" id="form-image" name="image" />
        </div>
        <div class="file-name" id="file-name"></div>
    </div>
    <div class="edit__profile-box">
        <label>ユーザー名<input type="text" name="name" /></label>
    </div>
    <div class="edit__profile-box">
        <label>郵便番号<input type="text" name="post" /></label>
    </div>
    <div class="edit__profile-box">
        <label>住所<input type="text" name="address" /></label>
    </div>
    <div class="edit__profile-box">
        <label>建物名<input type="text" name="building" /></label>
    </div>
    <div class="submit__button">
        <input type="submit" value="更新する" />
    </div>
</form>

<script src="{{ asset('js/profile-script.js') }}"></script>
@endsection