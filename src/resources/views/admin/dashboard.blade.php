@extends('layouts.app')

@section('main')
<div class="">
    <h1 class="mb-4">管理者ダッシュボード</h1>

    <a href="{{ route('admin.reviews.index') }}">口コミ管理</a>

    <!-- CSVインポートフォーム -->
    <div class="card p-4 mb-4">
        <h2 class="mb-3">CSVインポート</h2>
        <form action="{{ route('admin.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="csv_file" class="form-label">CSVファイルを選択</label>
                <input type="file" name="csv_file" id="csv_file" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-secondary">インポート</button>
        </form>

        <!-- CSV内容を表示 -->
        <div id="csv-preview" class="mt-4">
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

                tbody.innerHTML = ''; // 以前のプレビュー内容を消去

                // CSVのデータ行を作成
                lines.slice(1).forEach(line => {
                    const row = document.createElement('tr');
                    const columns = line.split(',');
                    const errorMessages = [];

                    // 店舗名（50文字以内）
                    const shopName = columns[0].trim();
                    if (shopName.length > 50) {
                        errorMessages.push('店舗名は50文字以内で入力してください。');
                    }

                    // 地域（東京都、大阪府、福岡県）
                    const region = columns[1].trim();
                    const validRegions = ['東京都', '大阪府', '福岡県'];
                    if (!validRegions.includes(region)) {
                        errorMessages.push('地域は「東京都」「大阪府」「福岡県」のいずれかで入力してください。');
                    }

                    // ジャンル（寿司、焼肉、イタリアン、居酒屋、ラーメン）
                    const genre = columns[2].trim();
                    const validGenres = ['寿司', '焼肉', 'イタリアン', '居酒屋', 'ラーメン'];
                    if (!validGenres.includes(genre)) {
                        errorMessages.push('ジャンルは「寿司」「焼肉」「イタリアン」「居酒屋」「ラーメン」のいずれかで入力してください。');
                    }

                    // 店舗概要（400文字以内）
                    const description = columns[3].trim();
                    if (description.length > 400) {
                        errorMessages.push('店舗概要は400文字以内で入力してください。');
                    }

                    // 画像URL（jpg、jpeg、pngのみ）
                    const imageUrl = columns[4].trim();
                    const imageExtension = imageUrl.split('.').pop().toLowerCase();
                    if (!['jpg', 'jpeg', 'png'].includes(imageExtension)) {
                        errorMessages.push('画像URLはjpg、jpeg、pngのみ対応しています。');
                    }

                    // 各セルに値を追加
                    const cells = [
                        shopName,
                        region,
                        genre,
                        description,
                        imageUrl,
                        errorMessages.length ? errorMessages.join('<br>') : '問題なし'
                    ];

                    cells.forEach((cellData, index) => {
                        const td = document.createElement('td');
                        if (index === 5 && errorMessages.length === 0) {
                            // エラーメッセージが無ければ「問題なし」ではなく空白にする
                            td.innerHTML = '';
                        } else {
                            td.innerHTML = cellData;
                        }
                        row.appendChild(td);
                    });

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