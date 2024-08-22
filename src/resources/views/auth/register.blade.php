<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>COACHTECH</title>
        <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    </head>

    <body>
        <header class="header">
            <h1 class="header__title">
                <a class="header__title-text" href="{{ route('index') }}">COACHTECH</a>
            </h1>
        </header>

        <div class="register__content">
            <div class="register__title">会員登録</div>
            @if(session()->has('success_message'))
                <p>{{ session('success_message') }}</p>
            @endif

            @if (count($errors) > 0)
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            @endif

            <div class="main__form">
                <form class="main__form-content" action="{{ route('register') }}" method="post">
                @csrf
                    <div class="name">
                        <label class="label">ユーザー名</label>
                        <input class="text__box" type="text" name="name" value="{{ old('name') }}" />
                    </div>
                    <div class="email">
                        <label class="label">メールアドレス</label>
                        <input class="text__box" type="email" name="email" value="{{ old('email') }}" />
                    </div>
                    <div class="password">
                        <label class="label">パスワード</label>
                        <input class="text__box" type="password" name="password" />
                    </div>
                    <div class="password__confirmation">
                        <label class="label">確認用パスワード</label>
                        <input class="text__box" type="password" name="password_confirmation" />
                    </div>
                    <div class="submit__button">
                        <input class="submit__button-item" type="submit" name="submit" value="登録する" />
                    </div>
                </form>
                <div class="link">
                    <a class="login__link" href="{{ route('show.login') }}">ログインはこちら</a>
                </div>
            </div>
        </div>
    </body>
</html>