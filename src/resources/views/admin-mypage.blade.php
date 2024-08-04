@extends('layouts.app')

@section('css')
@endsection

@section('content')
    <div class="top">
        <h1 class="top__content">{{ $user->name }}さん</h1>
    </div>

    <div class="create__admin-users">
        <form class="create__form" action="{{ route('show.admin') }}" method="get">
        @csrf
            <input type="submit" value="管理者作成">
        </form>
    </div>

    <div class="send__notification">
        <form class="notification__form-show" action="{{ route('show.send.notification') }}" method="get">
        @csrf
            <input type="submit" value="お知らせメール作成">
        </form>
    </div>

    <div class="remittance__amount">
        <form class="remittance__amount-show" action="{{ route('show.remittance.amount') }}" method="get">
        @csrf
            <input type="submit" value="送金額確認">
        </form>
    </div>

    <div class="create__coupon">
        <form class="create__coupon-show" action="{{ route('show.coupon') }}" method="get">
        @csrf
            <input type="submit" value="クーポン作成">
        </form>
    </div>
@endsection