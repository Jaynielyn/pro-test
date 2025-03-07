@extends('layouts.app')

@section('main')
<x-search></x-search>

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
@endsection