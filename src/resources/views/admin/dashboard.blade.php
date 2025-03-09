<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.app')

@section('main')
<div class="">
    <h1 class="mb-4">管理者ダッシュボード</h1>

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
    </div>
</div>
@endsection