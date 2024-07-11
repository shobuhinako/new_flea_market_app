<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>COACHTECH</title>
        <link rel="stylesheet" href="{{ asset('css/address.css') }}">
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
                <input type="hidden" id="item_id" name="item_id" value="{{ request()->item_id }}">
                <div class="edit__address">
                    <label>郵便番号</label>
                    <input type="text" name="post" value="{{ old('post') }}">
                </div>
                <div class="edit__address">
                    <label>住所</label>
                    <input type="text" name="address" value="{{ old('address') }}">
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
