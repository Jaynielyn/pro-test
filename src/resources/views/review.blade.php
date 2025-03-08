@extends('layouts.app')

@section('main')
<div class="review-container">
    <div class="left-section">
        <h2>今回のご利用はいかがでしたか？</h2>
        <div class="shop-card">
            <img src="{{ asset($shop->image_url) }}" alt="{{ $shop->name }}">
            <div class="shop-info">
                <h3>{{ $shop->name }}</h3>
                <p>#{{ $shop->region }} #{{ $shop->genre }}</p>
                <button>詳しくみる</button>
            </div>
        </div>
    </div>

    <div class="right-section">
        <h2>体験を評価してください</h2>

        @if ($errors->any())
        <div class="error-messages">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ isset($review) ? route('reviews.update', ['id' => $review->id]) : route('reviews.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($review))
            @method('PUT') {{-- 更新時 --}}
            @endif

            <input type="hidden" name="shop_id" value="{{ isset($review) ? $review->shop_id : $shop->id }}">

            <label>評価:</label>
            <div class="rating" id="star-rating">
                @for ($i = 1; $i <= 5; $i++)
                    <img src="{{ asset($i <= (isset($review) ? $review->rating : 0) ? 'img/star-blue.svg' : 'img/star-gray.svg') }}"
                    data-value="{{ $i }}" class="star">
                    @endfor
            </div>
            <input type="hidden" name="rating" id="rating-value" value="{{ isset($review) ? $review->rating : 0 }}">

            <textarea name="review" placeholder="カジュアルな夜のお出かけにおすすめのスポット">{{ old('review', isset($review) ? $review->review_text : '') }}</textarea>

            <label>画像を追加:</label>
            <input type="file" name="photo">

            @if(isset($review) && $review->photo_path)
            <p>現在の画像:</p>
            <img src="{{ asset('storage/' . $review->photo_path) }}" width="100">
            @endif

            <button type="submit" class="submit-btn">{{ isset($review) ? '口コミを更新' : '口コミを投稿' }}</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const stars = document.querySelectorAll(".star");
        const ratingValue = document.getElementById("rating-value");

        let selectedCount = 0; // 現在の評価（青い星の数）

        stars.forEach((star, index) => {
            star.addEventListener("click", function() {
                let value = parseInt(this.getAttribute("data-value"));

                if (value === selectedCount) {
                    // 右から順に消す（選択済みの最後の星を消す）
                    for (let i = stars.length - 1; i >= 0; i--) {
                        if (stars[i].src.includes("star-blue.svg")) {
                            stars[i].src = "{{ asset('img/star-gray.svg') }}";
                            selectedCount--;
                            break;
                        }
                    }
                } else {
                    // 星を選択（青くする）
                    for (let i = 0; i < value; i++) {
                        stars[i].src = "{{ asset('img/star-blue.svg') }}";
                    }
                    selectedCount = value; // 選択数更新
                }

                // 更新
                ratingValue.value = selectedCount;
            });
        });
    });
</script>
@endsection