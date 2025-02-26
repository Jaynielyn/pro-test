@extends('layouts.app')

@section('main')
<div class="card-container">
    @foreach($shops as $shop)
    <div class="card">
        <img src="{{ $shop->image_url }}" alt="{{ $shop->name }}">

        <div class="card-content">
            <h3>{{ $shop->name }} <span class="rating">★5.00</span></h3>
            <p>#{{ $shop->region }} #{{ $shop->genre }}</p>
            <button class="details">詳しく見る</button>
            <div class="favorite"><img></div>
        </div>
    </div>
    @endforeach
</div>

@endsection