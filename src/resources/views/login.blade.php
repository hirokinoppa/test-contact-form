@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('header')
  <div class="header-actions">
    <a href="{{ route('register.index') }}" class="header-btn">register</a>
  </div>
@endsection

@section('content')
<main class="admin-auth admin-auth--wide">
    <div class="admin-auth__overlay" aria-hidden="true">
        <h2 class="page-title">Login</h2>
    </div>

    <div class="register-wrapper">
        @error('login')
            <p class="error-message">{{ $message }}</p>
        @enderror

        <form method="POST" action="{{ route('login.store') }}" novalidate>
            @csrf

            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    class="input"
                    placeholder="例：test@example.com"
                    value="{{ old('email') }}"
                    required
                >
                @error('email')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">パスワード</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    class="input"
                    placeholder="例：coachtech1106"
                    required
                >
                @error('password')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn">ログイン</button>
            </div>
        </form>
    </div>
</main>
@endsection