@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('main')
<div class="index">
    <div class="header">
        <div class="header__top">
            <x-header></x-header>
            <x-search></x-search>
        </div>
        <!-- 選択した情報を表示 -->
        @if(request('sort'))
        <div class="selected__info">
            <p>情報検索：{{ request('sort') == 'random' ? 'ランダム' : (request('sort') == 'high' ? '評価が高い順' : '評価が低い順') }}</p>
        </div>
        @endif
    </div>

    <div class="card__container">
        @foreach($shops as $shop)
        <div class="card">
            <img class="card__img" src="{{ $shop->image_url }}" alt="{{ $shop->name }}">

            <div class="card__content">
                <h3>{{ $shop->name }}
                    <span class="rating">
                        ★{{ number_format($shop->average_rating ?? 0, 2) }}
                        ({{ $shop->review_count }}件)
                    </span>
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