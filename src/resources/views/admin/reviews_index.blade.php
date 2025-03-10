@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('main')
<h1>口コミ一覧</h1>

<div class="card-container">
    @foreach($shops as $shop)
    <div class="card">
        <img src="{{ $shop->image_url }}" alt="{{ $shop->name }}">

        <div class="card-content">
            <h3>{{ $shop->name }}</h3>
            <p>#{{ $shop->region }} #{{ $shop->genre }}</p>

            @if($shop->reviews->isNotEmpty())
            <a href="{{ route('admin.reviews.delete', ['shop' => $shop->id]) }}" class="details">詳しく見る</a>

            @else
            <p>口コミはまだありません</p>
            @endif
        </div>
    </div>
    @endforeach
</div>


@endsection