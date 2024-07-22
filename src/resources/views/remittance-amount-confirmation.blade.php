@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>送金額確認</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>販売日</th>
                    <th>出品者名</th>
                    <th>送金額</th>
                </tr>
            </thead>
            <tbody>
                @foreach($soldItems as $soldItem)
                    <tr>
                        <td>{{ $soldItem->created_at }}</td>
                        <td>{{ $soldItem->item->user->name }}</td>
                        <td>{{ $soldItem->item->price }}円</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection