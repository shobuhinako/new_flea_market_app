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
    <script src="https://js.stripe.com/v3/"></script>
</head>

<body>
    <header class="header">
        <h1 class="header__title">
            <a class="header__title-content" href="{{ route('index') }}">COACHTECH</a>
        </h1>

        <form class="search__form" action="{{ route('search') }}" method="get">
        @csrf
            <input type="text" name="search-box" placeholder="何をお探しですか？" value="{{ old('text') }}" />
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
                        @if(Auth::user()->role_id == 1)
                            <form class="header__menu-button" action="{{ route('show.admin.mypage') }}" method="get">
                            @csrf
                                <button class="mypage__button">マイページ</button>
                            </form>
                        @else
                            <form class="header__menu-button" action="{{ route('show.mypage') }}" method="get">
                            @csrf
                                <button class="mypage__button">マイページ</button>
                            </form>
                        @endif
                    </li>
                @else
                    <li class="header__menu-item">
                        <form class="header__menu-button" action="{{ route('show.register') }}" method="get">
                        @csrf
                            <button class="register__button">会員登録</button>
                        </form>
                    </li>
                @endif

                @if(Auth::check() && Auth::user()->role_id != 1)
                    <li class="header__menu-item">
                        <form class="header__menu-button" action="{{ route('show.display') }}" method="get">
                        @csrf
                            <button class="display__item-button">出品</button>
                        </form>
                    </li>
                @endif
            </ul>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>
</body>
</html>