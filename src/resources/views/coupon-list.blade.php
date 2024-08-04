@extends('layouts.app')

@section('content')
    <h1>クーポン一覧</h1>

    @if(session()->has('success_message'))
        <p>{{ session('success_message') }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>クーポンコード</th>
                <th>割引率 (%)</th>
                <th>使用期限</th>
                @if(auth()->user()->role_id == 1)
                    <th>状態</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($coupons as $coupon)
                <tr>
                    <td>{{ $coupon->code }}</td>
                    <td>{{ $coupon->discount }}</td>
                    <td>{{ $coupon->expires_at ? $coupon->expires_at->format('Y-m-d H:i') : 'なし' }}</td>
                    @if(auth()->user()->role_id == 1)
                        <td>
                            @if ($coupon->expires_at && $coupon->expires_at->isPast())
                                期限切れ
                            @else
                                有効
                            @endif
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
