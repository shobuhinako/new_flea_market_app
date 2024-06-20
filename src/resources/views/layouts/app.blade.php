<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('css')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
</head>

<body>
    <header class="header">
        <h1 class="header__title">
            <a href="{{ route('index') }}">COACHTECH</a>
        </h1>

        <form class="search__form">
        @csrf
            <input type="text" name="search-box" value="{{ old('text') }}" />
        </form>

        <nav class="header__menu">
            <ul class="header__menu-bar">
                @if(Auth::check())
                    <li class="header__menu-item">
                        <form class="header__menu-button" action="{{ route('logout') }}" method="post">
                        @csrf
                            <button class="logout__button">ログアウト</button>
                        </form>
                    </li>
                @else
                    <li class="header__menu-item">
                        <form class="header__menu-button" action="{{ route('show.login') }}" method="get">
                        @csrf
                            <button class="login__button">ログイン</button>
                        </form>
                    </li>
                @endif

                @if(Auth::check())
                    <li class="header__menu-item">
                        <form class="header__menu-button" action="{{ route('show.mypage') }}" method="get">
                        @csrf
                            <button class="mypage__button">マイページ</button>
                        </form>
                    </li>
                @else
                    <li class="header__menu-item">
                        <form class="header__menu-button" action="{{ route('show.register') }}" method="get">
                        @csrf
                            <button class="register__button">会員登録</button>
                        </form>
                    </li>
                @endif

                <li class="header__menu-item">出品</li>
            </ul>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>
</body>
</html>