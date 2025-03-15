@extends('layouts.app')



@section('main')
    <form method="POST" action="{{ route('admin.login') }}">
        @csrf
        <div>
            <label for="email">メールアドレス</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label for="password">パスワード</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit">ログイン</button>
    </form>
@endsection
