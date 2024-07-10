@extends('layouts.app')

@section('css')
@endsection

@section('content')
    @if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
    @endif
    @if(session()->has('success_message'))
            <p>{{ session('success_message') }}</p>
    @endif
    <div class="register__content">
        <div class="register__title">管理者作成</div>
        <div class="main__form">
            <form class="main__form-content" action="{{ route('create.admin') }}" method="post">
            @csrf
                <input type="text" name="name" value="{{ old('name') }}" placeholder="ユーザー名" />
                <input type="email" name="email" value="{{ old('email') }}" placeholder="メールアドレス" />
                <input type="password" name="password" placeholder="パスワード" />
                <input type="password" name="password_confirmation" placeholder="確認用パスワード" />
                <input type="submit" name="submit" value="登録する" />
            </form>
        </div>
    </div>


@endsection