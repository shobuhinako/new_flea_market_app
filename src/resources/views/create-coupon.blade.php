@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/create-coupon.css') }}">
@endsection

@section('content')
    <h1 class="title">クーポン作成</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session()->has('success_message'))
            <p>{{ session('success_message') }}</p>
    @endif

    <form class="create__coupon" action="{{ route('create.coupon') }}" method="post">
        @csrf
        <div class="create__coupon-box">
            <label for="discount">割引率 (%)</label>
            <input class="input__discount" type="number" name="discount" id="discount" required min="1" max="100">
        </div>
        <div class="create__coupon-box">
            <label for="expires_at">有効期限</label>
            <input class="input__expires" type="date" name="expires_at" id="expires_at">
        </div>
        <button type="submit">作成</button>
    </form>

    <div class="coupon__list">
        <form action="{{ route('show.coupon.list') }}" action="get">
        @csrf
            <input type="submit" value="クーポン一覧">
        </form>
    </div>
@endsection
