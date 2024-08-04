@extends('layouts.app')

@section('content')
    <h1>クーポン作成</h1>

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

    <form action="{{ route('create.coupon') }}" method="post">
        @csrf
        <div>
            <label for="discount">割引率 (%)</label>
            <input type="number" name="discount" id="discount" required min="1" max="100">
        </div>
        <div>
            <label for="expires_at">有効期限</label>
            <input type="date" name="expires_at" id="expires_at">
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
