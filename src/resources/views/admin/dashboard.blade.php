@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('main')
<div class="dashboard">
    <h1 class="dashboard__ttl">管理者ダッシュボード</h1>

    <a class="reviews__link" href="{{ route('admin.reviews.index') }}">口コミ管理</a>

    <!-- エラーメッセージ表示 -->
    @if ($errors->any())
    <div class="error-messages">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- CSVインポートフォーム -->
    <div class="csv__form">
        <h2 class="csv__ttl">CSVインポート</h2>
        <form class="form" action="{{ route('admin.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form__inner">
                <label for="csv_file" class="form__label">CSVファイルを選択</label>
                <input type="file" name="csv_file" id="csv_file" class="form__control" required>
            </div>
            <button type="submit" class="btn__secondary">インポート</button>
        </form>

        <!-- CSV内容を表示 -->
        <div id="csv-preview" class="preview">
            <h4>CSV内容プレビュー:</h4>
            <table id="csv-table" class="table table-bordered">
                <thead>
                    <tr>
                        <th>店舗名</th>
                        <th>地域</th>
                        <th>ジャンル</th>
                        <th>店舗概要</th>
                        <th>画像URL</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- CSVの内容はここに追加される -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.getElementById('csv_file').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file && file.type === 'text/csv') {
            const reader = new FileReader();
            reader.onload = function(e) {
                const contents = e.target.result;
                const lines = contents.split('\n');
                const table = document.getElementById('csv-table');
                const tbody = table.querySelector('tbody');

                tbody.innerHTML = '';

                lines.slice(1).forEach(line => {
                    const row = document.createElement('tr');
                    const columns = line.split(',');
                    const errorMessages = [];

                    const shopName = columns[0]?.trim() || '';
                    if (shopName.length > 50) {
                        errorMessages.push('店舗名は50文字以内で入力してください。');
                    }

                    const region = columns[1]?.trim() || '';
                    const validRegions = ['東京都', '大阪府', '福岡県'];
                    if (!validRegions.includes(region)) {
                        errorMessages.push('地域は「東京都」「大阪府」「福岡県」のいずれかで入力してください。');
                    }

                    const genre = columns[2]?.trim() || '';
                    const validGenres = ['寿司', '焼肉', 'イタリアン', '居酒屋', 'ラーメン'];
                    if (!validGenres.includes(genre)) {
                        errorMessages.push('ジャンルは「寿司」「焼肉」「イタリアン」「居酒屋」「ラーメン」のいずれかで入力してください。');
                    }

                    const description = columns[3]?.trim() || '';
                    if (description.length > 400) {
                        errorMessages.push('店舗概要は400文字以内で入力してください。');
                    }

                    const imageUrl = columns[4]?.trim() || '';
                    const imageExtension = imageUrl.split('.').pop().toLowerCase();
                    if (imageUrl && !['jpg', 'jpeg', 'png'].includes(imageExtension)) {
                        errorMessages.push('画像URLはjpg、jpeg、pngのみ対応しています。');
                    }

                    const cells = [shopName, region, genre, description, imageUrl];

                    cells.forEach(cellData => {
                        const td = document.createElement('td');
                        td.innerHTML = cellData;
                        row.appendChild(td);
                    });

                    if (errorMessages.length > 0) {
                        const errorTd = document.createElement('td');
                        errorTd.innerHTML = errorMessages.join('<br>');
                        errorTd.classList.add('error');
                        row.appendChild(errorTd);
                    }

                    tbody.appendChild(row);
                });
            };
            reader.readAsText(file);
        } else {
            alert('CSVファイルを選択してください。');
        }
    });
</script>
@endsection