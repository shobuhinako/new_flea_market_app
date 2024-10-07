@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="top__content">プロフィール設定</div>

@if(session()->has('success'))
    <p>{{ session('success') }}</p>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form class="edit__profile" action="{{ route('edit.profile') }}" method="post" enctype="multipart/form-data">
@csrf
@method('PUT')
    <div class="profile__image">
        <img class="rounded__image" src="{{ $user->profile && $user->profile->image ? asset('storage/images/' . $user->profile->image) : '' }}">
        <div class="file-input-wrapper">
            <label class="custom-file-label" for="form-image">画像を選択する</label>
            <input type="file" id="form-image" name="image" />
        </div>
        <div class="file-name" id="file-name"></div>
    </div>
    <div class="edit__profile-box">
        <label class="edit__label">ユーザー名</label><br />
        <input class="edit__box" type="text" name="name" />
    </div>
    <div class="edit__profile-box">
        <label class="edit__label">郵便番号</label><br />
        <input class="edit__box" type="text"  id="postcode" name="post" />
    </div>
    <div class="edit__profile-box">
        <label class="edit__label">住所</label><br />
        <input class="edit__box" type="text" id="address" name="address" />
    </div>
    <div class="edit__profile-box">
        <label class="edit__label">建物名</label><br />
        <input class="edit__box" type="text" name="building" />
    </div>
    <div class="submit__button">
        <input class="submit__button-item" type="submit" value="更新する" />
    </div>
</form>

<script src="{{ asset('js/profile-script.js') }}"></script>
@endsection