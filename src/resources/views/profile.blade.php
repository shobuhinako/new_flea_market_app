@extends('layouts.app')

@section('css')
@endsection

@section('content')
<div class="top__content">プロフィール設定</div>
<form class="edit__profile" action="" method="post">
@csrf
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
@endsection