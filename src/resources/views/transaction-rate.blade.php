@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/transaction-rate.css') }}">
@endsection

@section('content')
    @if(session()->has('success'))
        <p>{{ session('success') }}</p>
    @endif

    <div class="rating">
        <div class="rating__comment">
            取引評価をお願いします。
        </div>

        @error('point')
            <div class="error-message" style="color: red;">
                {{ $message }}
            </div>
        @enderror

        <form class="transaction__complete-submit" action="{{ route('transaction.complete', $item->id) }}" method="post">
        @csrf
            <table class="rating__transaction-content">
                <tr class="rating__transaction">
                    <th class="rating__transaction-name">取引評価</th>
                    <td class="rating__transaction-item">
                        <select name="point" id="point">
                            <option value="" disabled selected>選択してください</option>
                            <option value="1">1. 不満</option>
                            <option value="2">2.やや不満 </option>
                            <option value="3">3. 満足</option>
                            <option value="4">4. かなり満足</option>
                            <option value="5">5. 大変満足</option>
                        </select>
                    </td>
                </tr>
            </table>
            @if(Auth::user()->id == $item->user_id)
                <button class="transaction__complete-button" @if($soldItem->is_completed_by_seller) disabled @endif>取引完了</button>
            @else
                <button class="transaction__complete-button" @if ($soldItem->is_completed_by_buyer) disabled @endif>取引完了</button>
            @endif
        </form>
    </div>
@endsection