@extends('layouts.app')

@section('css')
@endsection

@section('content')
    <div class="top__content">テストさん</div>
    <form class="edit__profile" action="{{ route('show.profile') }}" method="get">
    @csrf
        <button class="edit__profile-button">プロフィールを編集</button>
    </form>
    @endsection