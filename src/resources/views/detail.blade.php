@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('main')
<div class="detail">
    <div class="shop__info">
        <x-header></x-header>
        <div class="detail__top">
            <button class="back__button" onclick="history.back()">
                <
            </button>
                    <h1 class="detail__ttl">{{ $shop->name }}</h1>
        </div>

        <img src="{{ asset($shop->image_url) }}" alt="{{ $shop->name }}" class="shop__image">

        <p class="tags">#{{ $shop->region }} #{{ $shop->genre }}</p>
        <p class="description">{{ $shop->description }}</p>

        @if($shop->reviews->count() > 0)
        <h2 class="sub__ttl">全ての口コミ情報</h2>
        <div class="reviews__inner">
            @foreach($shop->reviews as $review)
            <div class="review" style="display: flex; align-items: flex-start; gap: 15px; margin-bottom: 20px;">
                <div class="edit__link">
                    @if($review->user_id === Auth::id())
                    <a href="{{ route('review.edit', ['id' => $review->id]) }}">口コミを編集</a>
                    <form action="{{ route('review.destroy', ['id' => $review->id]) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="delete" type="submit" onclick="return confirm('本当に削除しますか？');">口コミを削除</button>
                    </form>
                    @endif
                </div>
                <div class="reviews__inner" style="flex: 1;">
                    <div class="stars">
                        @for ($i = 1; $i <= 5; $i++)
                            <img src="{{ asset($i <= $review->rating ? 'img/star-blue.svg' : 'img/star-gray.svg') }}"
                            alt="星" class="star__img">
                            @endfor
                    </div>
                    <p style="margin-top: 5px;">{{ $review->review_text }}</p>
                </div>
                @if($review->photo_path)
                <img src="{{ asset('storage/' . $review->photo_path) }}"
                    alt="口コミ画像"
                    class="review__img"
                    style="width: 150px; height: auto; border-radius: 5px;">
                @endif
            </div>
            @endforeach
        </div>
        @endif

        @php
        $userReviewExists = $shop->reviews->where('user_id', Auth::id())->isNotEmpty();
        @endphp

        @if(!$userReviewExists)
        <a href="{{ route('review', ['shop_id' => $shop->id]) }}" class="review__link">口コミを投稿する</a>
        @endif
    </div>

    <div class="shop__info right">
        <div class="reservation__form">
            <form class="form" action="#" method="POST">
                @csrf
                <h2>予約</h2>
                <input type="date" id="date" name="date" value="{{ now()->format('Y-m-d') }}">

                <select id="time" name="time">
                    <option value="17:00">17:00</option>
                    <option value="18:00">18:00</option>
                    <option value="19:00">19:00</option>
                </select>

                <select id="number" name="number">
                    <option value="1">1人</option>
                    <option value="2">2人</option>
                    <option value="3">3人</option>
                    <option value="4">4人</option>
                </select>

                <div class="summary">
                    <p class="summary__inner"><strong>Shop:</strong> {{ $shop->name }}</p>
                    <p class="summary__inner"><strong>Date:</strong> <span id="selected-date">{{ now()->format('Y-m-d') }}</span></p>
                    <p class="summary__inner"><strong>Time:</strong> <span id="selected-time">17:00</span></p>
                    <p class="summary__inner"><strong>Number:</strong> <span id="selected-number">1人</span></p>
                </div>
            </form>
            <button type="submit" class="reserve__btn">予約する</button>
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