@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('main')
<div class="mypage">
    <div class="mypage__header"><x-header></x-header></div>
    <h1 class="mypage__name">{{ $user->name }}さん</h1>

    <div class="mypage__content">
        <!-- 左側 -->
        <div class="left__page">
            <h2 class="mypage__ttl">予約状況</h2>
            @foreach($reservations as $reservation)
            <div class="book__box">
                <div class="book__item item-top">
                    <div class="item__clock">
                        <img class="img" src="/img/clock.png" style="width: 30%;">
                        <p>予約{{ $loop->iteration }}</p>
                    </div>
                    <!-- 予約削除ボタン -->
                    <form action="{{ route('reservation.destroy', $reservation->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: none; border: none;">
                            <img class="img" src="{{ asset('img/circle-xmark-regular.svg') }}" style="width: 5%;">
                        </button>
                    </form>

                </div>
                <div class="book__item">
                    <h5 class="item__ttl">Shop</h5>
                    <p class="item__inner">{{ $reservation->shop->name }}</p>
                </div>
                <div class="book__item">
                    <h5 class="item__ttl">Date</h5>
                    <p class="item__inner">{{ $reservation->date }}</p>
                </div>
                <div class="book__item">
                    <h5 class="item__ttl">Time</h5>
                    <p class="item__inner">{{ $reservation->time }}</p>
                </div>
                <div class="book__item">
                    <h5 class="item__ttl">Number</h5>
                    <p class="item__inner">{{ $reservation->number }}人</p>
                </div>
            </div>
            @endforeach
        </div>

        <!-- 右側 -->
        <div class="right__page">
            <h2 class="mypage__ttl">お気に入り店舗</h2>
            <div class="likes__box">
                @foreach($likedShops as $shop)
                <div class="like__item">
                    <h5>{{ $shop->name }}</h5>
                    <p>{{ $shop->region }} | {{ $shop->genre }}</p>
                    <img src="{{ asset($shop->image_url) }}" alt="{{ $shop->name }}" class="shop__image" style="width: 10%;">
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection