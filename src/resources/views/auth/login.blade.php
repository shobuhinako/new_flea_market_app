<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>COACHTECH</title>
        <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    </head>

    <body>
        <header class="header">
            <h1 class="header__title">
                <a class="header__title-text" href="{{ route('index') }}">COACHTECH</a>
            </h1>
        </header>

        <div class="login__content">
            <div class="login__title">ログイン</div>
            @if (count($errors) > 0)
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </ul>
            @endif
            <div class="main__form">
                <form class="main__form-content" action="{{ route('login') }}" method="post">
                @csrf
                    <div class="email">
                        <label class="label">メールアドレス</label>
                        <input class="text__box" type="email" name="email" value="{{ old('email') }}" />
                    </div>
                    <div class="password">
                        <label class="label">パスワード</label>
                        <input class="text__box" type="password" name="password" />
                    </div>
                    <div class="login__button">
                        <input class="login__button-item" type="submit" name="submit" value="ログインする" />
                    </div>
                </form>
                <div class="link">
                    <a class="register__link" href="{{ route('show.register') }}">会員登録はこちら</a>
                </div>
            </div>
        </div>
    </body>
</html>