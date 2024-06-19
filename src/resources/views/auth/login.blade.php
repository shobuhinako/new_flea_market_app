<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>COACHTECH</title>
    </head>

    <body>
        <header class="header">
            <h1 class="header__title">
                <a href="{{ route('index') }}">COACHTECH</a>
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
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="メールアドレス" />
                    <input type="password" name="password" placeholder="パスワード" />
                    <input type="submit" name="submit" value="ログインする" />
                </form>
                <div class="link">
                    <a class="login__link" href="{{ route('show.register') }}">会員登録はこちら</a>
                </div>
            </div>
        </div>
    </body>
</html>