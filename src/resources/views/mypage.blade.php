@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
    <div class="profile__image">
        <img class="rounded__image" src="{{ Storage::url('images/' . $user->image_path) }}" alt="プロフィール画像" />
    </div>
    <div class="top__content">{{ $user->name }}</div>
    <form class="edit__profile" action="{{ route('show.profile') }}" method="get">
    @csrf
        <button class="edit__profile-button">プロフィールを編集</button>
    </form>
    @endsection