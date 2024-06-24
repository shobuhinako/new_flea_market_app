@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
    <div class="profile__image">
        <img class="rounded__image" src="{{ Storage::url('images/' . $user->image_path) }}" alt="プロフィール画像" />
    </div>
    <div class="top__content">{{ $user->name }}</div>
    <form class="edit__profile" action="{{ route('show.profile') }}" method="get">
    @csrf
        <button class="edit__profile-button">プロフィールを編集</button>
    </form>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="items-tab" data-toggle="tab" href="#items" role="tab" aria-controls="items" aria-selected="true">出品した商品</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="purchases-tab" data-toggle="tab" href="#purchases" role="tab" aria-controls="purchases" aria-selected="false">購入した商品</a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="items" role="tabpanel" aria-labelledby="items-tab">
            <div class="row">
                @foreach($items as $item)
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <img class="card-img-top" src="{{ Storage::url('images/' . $item->image_path) }}" alt="{{ $item->name }}">
                            <div class="card-body">
                                <p class="card-text">{{ $item->name }}</p>
                                <p class="card-text">{{ $item->price }}円</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @section('js')
        <script>
            $(document).ready(function () {
            $('#myTab a').on('click', function (e) {
            e.preventDefault();
            $(this).tab('show');
            });
            });
        </script>
    @endsection
@endsection