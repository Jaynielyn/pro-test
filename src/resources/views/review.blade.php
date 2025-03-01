@extends('layouts.app')

@section('main')
<div class="review-container">
    <div class="left-section">
        <h2>今回のご利用はいかがでしたか？</h2>
        <div class="shop-card">
            <img src="sushi.jpg" alt="寿司職人">
            <div class="shop-info">
                <h3>仙人</h3>
                <p>#東京都 #寿司</p>
                <button>詳しくみる</button>
            </div>
        </div>
    </div>

    <div class="right-section">
        <h2>体験を評価してください</h2>
        <div class="rating">
            ★★★★☆
        </div>

        <textarea placeholder="カジュアルな夜のお出かけにおすすめのスポット"></textarea>

        <div class="image-upload">
            <p>クリックして写真を追加 <br> またはドラッグアンドドロップ</p>
        </div>

        <button class="submit-btn">口コミを投稿</button>
    </div>
</div>
@endsection