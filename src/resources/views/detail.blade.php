@extends('layouts.app')

@section('css')
@endsection

@section('content')
    <div class="item__image">
        <img class="item__image-content" src="" alt="イメージ画像">
    </div>

    <div class="item__detail">
        <div class="item__name">商品名</div>
        <div class="brand__name">ブランド名</div>
        <div class="price">￥47,000(値段)</div>
        <form class="purchase__button">
        @csrf
            <input type="submit" value="購入する">
        </form>

        <div class="item__description">商品説明</div>
        <div class="item__color">カラー：グレー</div>
        <div class="item__condition">新品</div>
        <div class="item__condition-comment">
            商品の状態は良好です。傷もありません。</br>
            購入後、即発送いたします。
        </div>

        <div class="item__information">
        <table class="item__information-table">
            <tr>
                <th>カテゴリー<th>
                <td>洋服</td>
                <td>メンズ</td>
            </tr>
            <tr>
                <th>商品の状態</th>
                <td>良好</td>
            </tr>
        </table>
@endsection