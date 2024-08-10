@extends('layouts.app')

@section('css')
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

    <form action="{{ route('send.notification') }}" method="post">
    @csrf
    <div>
        <p>宛先</p>
        <select name="destination">
            <option value="all">全員</option>
            <option value="admin">管理者</option>
            <option value="user">ユーザー</option>
        </select>
    </div>

    <div>
        <p>本文</p>
        <textarea name="message"></textarea>
    </div>
    <div>
        <button type="submit">メール送信</button>
    </div>
</form>
@endsection