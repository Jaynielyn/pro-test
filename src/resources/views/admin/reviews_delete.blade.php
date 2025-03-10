@extends('layouts.app')

@section('main')
<div class="review-details">
    <h2>店舗の口コミ一覧</h2>

    <!-- 店舗情報 -->
    <div class="shop-info">
        <h3>{{ $shop->name }}</h3>

        @if($shop->image_url)
        <img src="{{ asset('storage/' . $shop->image_path) }}" alt="{{ $shop->name }}" style="max-width: 400px; height: auto;">
        @else
        <img src="{{ asset('images/default-shop-image.jpg') }}" alt="デフォルト画像" style="max-width: 200px; height: auto;">
        @endif

        <p>#{{ $shop->region }} #{{ $shop->genre }}</p>
    </div>

    <h4>口コミ一覧</h4>

    <!-- 口コミがある場合 -->
    @if($reviews->count() > 0)
    @foreach($reviews as $review)
    <div class="review-info">
        @if($review->photo_path)
        <img src="{{ asset('storage/' . $review->photo_path) }}" alt="口コミ画像" style="max-width: 100px; height: auto;">
        @else
        <img src="{{ asset('images/default-review-image.jpg') }}" alt="デフォルト画像" style="max-width: 100px; height: auto;">
        @endif
        <p><strong>ユーザー名:</strong> {{ $review->user->name }}</p>
        <p><strong>口コミ内容:</strong> {{ $review->review_text }}</p>
        <p><strong>評価:</strong> ★{{ $review->rating }}</p>

        <!-- 口コミ削除フォーム -->
        <form action="{{ route('admin.reviews.destroy', ['review' => $review->id]) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">この口コミを削除</button>
        </form>
    </div>
    @endforeach
    @else
    <p>この店舗にはまだ口コミがありません。</p>
    @endif

    <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">戻る</a>
</div>
@endsection