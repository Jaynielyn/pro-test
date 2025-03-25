@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('main')
<x-header></x-header>

<main class="register">
    <form class="register__form" action="/register" method="post">
        @csrf
        <div class="register__ttl">
            <h2>Registration</h2>
        </div>
        <div class="register__item">
            <img class="register__img" src="/img/name.png" alt="username-icon" width="25px" />
            <input class="register__input" type="text" placeholder="Username" name="name" />
            @error('name')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>
        <div class="register__item">
            <img class="register__img" src="/img/email.png" alt="email-icon" width="25px" />
            <input class="register__input" type="email" placeholder="Email" name="email" />
            @error('email')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>
        <div class="register__item">
            <img class="register__img" src="/img/password.png" alt="password-icon" width="25px" />
            <input class="register__input" type="password" placeholder="Password" name="password" />
            @error('password')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>
        <div class="register__btn">
            <input type="submit" value="登録" />
        </div>
    </form>
</main>
@endsection