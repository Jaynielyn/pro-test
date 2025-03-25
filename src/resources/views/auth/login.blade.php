@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('main')
<x-header></x-header>

<div class="login">
    <form class="login__form" action="/login" method="post">
        @csrf
        <div class="login__ttl">
            <h2>Login</h2>
        </div>
        <div class="login__item">
            <img class="login__img" src="/img/email.png" alt="email-icon" width="25px" />
            <input class="login__input" type="email" placeholder="Email" name="email" />
            @error('email')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>
        <div class="login__item">
            <img class="login__img" src="/img/password.png" alt="password-icon" width="25px" />
            <input class="login__input" type="password" placeholder="Password" name="password" />
            @error('password')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>
        <div class="login__btn">
            <input type="submit" value="ログイン" />
        </div>
    </form>
</div>
@endsection