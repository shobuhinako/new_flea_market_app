@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/send-notification.css') }}">
@endsection

@section('content')
    @if(session()->has('success'))
            <p>{{ session('success') }}</p>
    @endif

    @if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
    @endif

    <form class="send__form" action="{{ route('send.notification') }}" method="post">
    @csrf
    <div class="mail__destination">
        <p class="title">宛先</p>
        <select name="destination">
            <option value="all">全員</option>
            <option value="admin">管理者</option>
            <option value="user">ユーザー</option>
        </select>
    </div>

    <div class="mail__content">
        <p class="title">本文</p>
        <textarea class="mail__content" name="message"></textarea>
    </div>
    <div>
        <button type="submit">メール送信</button>
    </div>
</form>
@endsection