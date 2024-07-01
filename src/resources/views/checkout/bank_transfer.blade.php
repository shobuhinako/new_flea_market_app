@extends('layouts.app')

@section('content')
    <h1>銀行振込</h1>
    <p>以下の情報を使って、銀行振込を完了してください：</p>
    <p>銀行名: ○○銀行</p>
    <p>支店名: ○○支店</p>
    <p>口座番号: 1234567</p>
    <p>振込人名義: {{ Auth::user()->name }}</p>
    <p>振込金額: ￥{{ number_format($item->price) }}</p>
    <p>振込ID: {{ $paymentIntent->id }}</p>
@endsection
