@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review.css') }}">
@endsection

@section('main')
<div class="review">
    <div class="review__container">
        <div class="left__section">
            <x-header></x-header>
            <h2>今回のご利用はい<br>かがでしたか？</h2>
            <div class="shop__card">
                <img class="shop__img" src="{{ asset($shop->image_url) }}" alt="{{ $shop->name }}">
                <div class="shop__info">
                    <h3>{{ $shop->name }}</h3>
                    <p class="hashtag">#{{ $shop->region }} #{{ $shop->genre }}</p>
                    <button class="info__btn">詳しくみる</button>
                </div>
            </div>
        </div>

        <!-- 右側 -->
        <div class="right__section">
            <h2>体験を評価してください</h2>

            <form action="{{ isset($review) ? route('reviews.update', ['id' => $review->id]) : route('reviews.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($review))
                @method('PUT') {{-- 更新時 --}}
                @endif

                <input type="hidden" name="shop_id" value="{{ isset($review) ? $review->shop_id : $shop->id }}">

                <div class="rating" id="star-rating">
                    @for ($i = 1; $i <= 5; $i++)
                        <img src="{{ asset($i <= (isset($review) ? $review->rating : 0) ? 'img/star-blue.svg' : 'img/star-gray.svg') }}"
                        data-value="{{ $i }}" class="star">
                        @endfor
                </div>
                <input type="hidden" name="rating" id="rating-value" value="{{ isset($review) ? $review->rating : 0 }}">

                <label class="review__label">口コミを投稿</label>
                <textarea name="review" placeholder="カジュアルな夜のお出かけにおすすめのスポット">{{ old('review', isset($review) ? $review->review_text : '') }}</textarea>
                @error('review')
                <span class="error">{{ $message }}</span>
                @enderror

                <label class="review__label">画像を追加</label>
                <input type="file" name="photo">

                @if(isset($review) && $review->photo_path)
                <p>画像の追加:</p>
                <img src="{{ asset('storage/' . $review->photo_path) }}" width="100">
                @endif
                @error('photo')
                <span class="error">{{ $message }}</span>
                @enderror

                <div class="button">
                    <button type="submit" class="submit__btn">{{ isset($review) ? '口コミを更新' : '口コミを投稿' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const stars = document.querySelectorAll(".star");
        const ratingValue = document.getElementById("rating-value");

        let selectedCount = 0;

        stars.forEach((star, index) => {
            star.addEventListener("click", function() {
                let value = parseInt(this.getAttribute("data-value"));

                if (value === selectedCount) {
                    for (let i = stars.length - 1; i >= 0; i--) {
                        if (stars[i].src.includes("star-blue.svg")) {
                            stars[i].src = "{{ asset('img/star-gray.svg') }}";
                            selectedCount--;
                            break;
                        }
                    }
                } else {
                    for (let i = 0; i < value; i++) {
                        stars[i].src = "{{ asset('img/star-blue.svg') }}";
                    }
                    selectedCount = value;
                }

                ratingValue.value = selectedCount;
            });
        });
    });
</script>
@endsection