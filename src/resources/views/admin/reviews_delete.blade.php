@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/delete.css') }}">
@endsection

@section('main')
<div class="review__details">
    <h2 class="delete__ttl">店舗の口コミ一覧</h2>
    <button class="back__button" onclick="history.back()">
        <
    </button>

    <!-- 店舗情報 -->
    <div class="shop__info">
        <h3 class="shop__info-ttl">{{ $shop->name }}</h3>

        @if($shop->image_url)
        <img src="{{ asset('storage/' . $shop->image_path) }}" alt="{{ $shop->name }}" style="max-width: 600px; height: auto;">
        @else
        <img src="{{ asset('images/default-shop-image.jpg') }}" alt="デフォルト画像" style="max-width: 200px; height: auto;">
        @endif

        <p>#{{ $shop->region }} #{{ $shop->genre }}</p>
        <p>{{ $shop->description }}</p>
    </div>

    <h4>口コミ一覧</h4>

    <!-- 口コミがある場合 -->
    @if($reviews->count() > 0)
    @foreach($reviews as $review)
    <div class="review__info">
        @if($review->photo_path)
        <img src="{{ asset('storage/' . $review->photo_path) }}" alt="口コミ画像" style="max-width: 100px; height: auto;">
        @endif
        <div class="info__inner">
            <p><strong>ユーザー名:</strong> {{ $review->user->name }}</p>
            <p><strong>口コミ内容:</strong> {{ $review->review_text }}</p>
            <p><strong>評価:</strong> ★{{ $review->rating }}</p>
            <!-- 口コミ削除フォーム -->
            <form action="{{ route('admin.reviews.destroy', ['review' => $review->id]) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete__btn btn__danger">口コミを削除</button>
            </form>
        </div>

    </div>
    @endforeach
    @else
    <p>この店舗にはまだ口コミがありません。</p>
    @endif
</div>
@endsection