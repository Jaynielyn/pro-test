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
                        <img class="img" src="/img/clock.png">
                        <p>予約{{ $loop->iteration }}</p>
                    </div>
                    <form action="{{ route('reservation.destroy', $reservation->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">
                            <img class="img" src="{{ asset('img/circle-xmark-regular.svg') }}">
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
                <div class="card">
                    <img src="{{ asset($shop->image_url) }}" alt="{{ $shop->name }}" class="card__img">

                    <div class="card__content">
                        <h3>{{ $shop->name }}
                        </h3>
                        <p>#{{ $shop->region }} #{{ $shop->genre }}</p>
                        <div class="like__btn">
                            <a href="{{ route('shops.detail', ['id' => $shop->id]) }}" class="detail__btn">詳しく見る</a>
                            <button class="like-button" data-shop-id="{{ $shop->id }}" @guest disabled @endguest>
                                @auth
                                @if(Auth::user()->isLikedBy($shop))
                                <img src="{{ asset('img/heart-pink.svg') }}" class="heart-icon" alt="いいね済み">
                                @else
                                <img src="{{ asset('img/heart-gray.svg') }}" class="heart-icon" alt="未いいね">
                                @endif
                                @else
                                <img src="{{ asset('img/heart-gray.svg') }}" class="heart-icon" alt="未いいね">
                                @endauth
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".like-button").forEach(button => {
            button.addEventListener("click", function() {
                // 未ログイン時の処理
                if (this.hasAttribute("disabled")) {
                    alert("いいねするにはログインしてください");
                    return;
                }

                const shopId = this.dataset.shopId;
                const button = this;
                const img = button.querySelector(".heart-icon");

                fetch("/like", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                        },
                        body: JSON.stringify({
                            shop_id: shopId
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.liked) {
                            img.src = "/img/heart-pink.svg";
                            img.alt = "いいね済み";
                        } else {
                            img.src = "/img/heart-gray.svg";
                            img.alt = "未いいね";
                        }
                    })
                    .catch(error => console.error("Error:", error));
            });
        });
    });
</script>
@endsection