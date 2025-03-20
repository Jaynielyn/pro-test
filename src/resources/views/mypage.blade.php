@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('main')
<div class="mypage">
    <div class="mypage__header"><x-header></x-header></div>
    <h1 class="mypage__name">あああさん</h1>

    <div class="mypage__content">
        <!-- 左側 -->
        <div class="left__page">
            <h2 class="mypage__ttl">予約状況</h2>
            <div class="book__box">
                <div class="book__item item-top">
                    <div class="item__clock">
                        <img class="img" src="/img/clock.png" style="width: 30%;">
                        <p>予約1</p>
                    </div>
                    <img class="img" src="{{ asset('img/circle-xmark-regular.svg') }}" style="width: 5%;">
                </div>
                <div class="book__item">
                    <h5 class="item__ttl">Shop</h5>
                    <p class="item__inner">aaa</p>
                </div>
                <div class="book__item">
                    <h5 class="item__ttl">Date</h5>
                    <p class="item__inner">aaa</p>
                </div>
                <div class="book__item">
                    <h5 class="item__ttl">Time</h5>
                    <p class="item__inner">aaa</p>
                </div>
                <div class="book__item">
                    <h5 class="item__ttl">Number</h5>
                    <p class="item__inner">aaa</p>
                </div>
            </div>
        </div>

        <!-- 右側 -->
        <div class="right__page">
            <h2 class="mypage__ttl">お気に入り店舗</h2>
            <div class="likes__box"></div>
        </div>
    </div>
</div>
@endsection