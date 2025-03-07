@extends('layouts.app')

@section('main')
<div class="review-container">
    <div class="shop-info">
        <h1>{{ $shop->name }}</h1>

        <img src="{{ asset($shop->image_url) }}" alt="{{ $shop->name }}" class="shop-image">

        <p class="tags">#{{ $shop->region }} #{{ $shop->genre }}</p>
        <p class="description">{{ $shop->description }}</p>

        @if($shop->reviews->count() > 0)
        <h2 class="sub__ttl">全ての口コミ情報</h2>
        <div class="reviews">
            <a href="#">口コミを編集</a>
            <a href="#">口コミを削除</a>
            @foreach($shop->reviews as $review)
            <div class="review" style="display: flex; align-items: flex-start; gap: 15px; margin-bottom: 20px;">
                <div class="reviews__inner" style="flex: 1;">
                    <div class="stars">
                        @for ($i = 1; $i <= 5; $i++)
                            <img src="{{ asset($i <= $review->rating ? 'img/star-blue.svg' : 'img/star-gray.svg') }}"
                            alt="星" class="star-img">
                            @endfor
                    </div>
                    <p style="margin-top: 5px;">{{ $review->review_text }}</p>
                </div>
                @if($review->photo_path)
                <img src="{{ asset('storage/' . $review->photo_path) }}"
                    alt="口コミ画像"
                    class="review-img"
                    style="width: 150px; height: auto; border-radius: 5px;">
                @endif
            </div>
            @endforeach
        </div>
        @endif

        @if($shop->reviews->count() === 0)
        <a href="{{ route('review', ['shop_id' => $shop->id]) }}" class="review-link">口コミを投稿する</a>
        @endif
    </div>

    <div class="shop-info">
        <div class="reservation-form">
            <h2>予約</h2>
            <form action="#" method="POST">
                @csrf
                <label for="date">日付</label>
                <input type="date" id="date" name="date" value="{{ now()->format('Y-m-d') }}">

                <label for="time">時間</label>
                <select id="time" name="time">
                    <option value="17:00">17:00</option>
                    <option value="18:00">18:00</option>
                    <option value="19:00">19:00</option>
                </select>

                <label for="number">人数</label>
                <select id="number" name="number">
                    <option value="1">1人</option>
                    <option value="2">2人</option>
                    <option value="3">3人</option>
                    <option value="4">4人</option>
                </select>

                <div class="summary">
                    <p><strong>Shop:</strong> {{ $shop->name }}</p>
                    <p><strong>Date:</strong> <span id="selected-date">{{ now()->format('Y-m-d') }}</span></p>
                    <p><strong>Time:</strong> <span id="selected-time">17:00</span></p>
                    <p><strong>Number:</strong> <span id="selected-number">1人</span></p>
                </div>

                <button type="submit" class="reserve-btn">予約する</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateInput = document.getElementById('date');
        const timeSelect = document.getElementById('time');
        const numberSelect = document.getElementById('number');

        const selectedDate = document.getElementById('selected-date');
        const selectedTime = document.getElementById('selected-time');
        const selectedNumber = document.getElementById('selected-number');

        dateInput.addEventListener('input', function() {
            selectedDate.textContent = dateInput.value;
        });

        timeSelect.addEventListener('change', function() {
            selectedTime.textContent = timeSelect.value;
        });

        numberSelect.addEventListener('change', function() {
            selectedNumber.textContent = numberSelect.options[numberSelect.selectedIndex].text;
        });
    });
</script>

@endsection