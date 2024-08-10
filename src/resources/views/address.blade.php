<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>COACHTECH</title>
        <link rel="stylesheet" href="{{ asset('css/address.css') }}">
        <script src="{{ asset('js/address-script.js') }}"></script>
        <script src="https://yubinbango.github.io/yubinbango/yubinbango.js"></script>
    </head>

    <body>
        <header class="header">
        </header>

        <div class="change__address">
            <div class="title">
                <h1 class="title__message">住所の変更</h1>
            </div>
            <form class="change__address-form" action="{{ route('update.address') }}" method="post">
            @csrf

            @if ($errors->any())
                <div class="error-summary">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

                <input type="hidden" class="p-country-name" value="Japan">
                <input type="hidden" id="item_id" name="item_id" value="{{ request()->item_id }}">
                <div class="edit__address">
                    <label>郵便番号</label>
                    <input type="text" id="post" class="p-postal-code" name="post" value="{{ old('post') }}">
                </div>
                <div class="edit__address">
                    <label>住所</label>
                    <input type="text" id="address" class="p-region p-locality p-street-address p-extended-address" name="address" value="{{ old('address') }}">
                </div>
                <div class="edit__address">
                    <label>建物名</label>
                    <input type="text" name="building" value="{{ old('building') }}">
                </div>
                <div class="submit__button">
                    <input type="submit" value="更新する">
                </div>
            </form>
        </div>
    </body>
</html>
