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
        <div class="selected-info">
            <p>情報検索：{{ request('sort') == 'random' ? 'ランダム' : (request('sort') == 'high' ? '評価が高い順' : '評価が低い順') }}</p>
        </div>
        @endif
    </div>

    <div class="card-container">
        @foreach($shops as $shop)
        <div class="card">
            <img src="{{ $shop->image_url }}" alt="{{ $shop->name }}">

            <div class="card-content">
                <h3>{{ $shop->name }}
                    <span class="rating">
                        ★{{ number_format($shop->average_rating ?? 0, 2) }}
                        ({{ $shop->review_count }}件)
                    </span>
                </h3>
                <p>#{{ $shop->region }} #{{ $shop->genre }}</p>
                <a href="{{ route('shops.detail', ['id' => $shop->id]) }}" class="details">詳しく見る</a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection