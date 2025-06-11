@extends('layouts.main')

@section('title', 'Логін')

@section('content')
    <div class="container">
        <h2>Вхід</h2>
        <form method="POST" action="{{ route('login') }}" class="col-md-6">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus>
                @error('email')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Пароль</label>
                <input type="password" name="password" id="password" class="form-control" required>
                @error('password')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" name="remember" id="remember" class="form-check-input">
                    <label for="remember" class="form-check-label">Запам'ятати мене</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Увійти</button>
            <a href="{{ route('register') }}" class="btn btn-link">Реєстрація</a>
        </form>

        <div class="mt-3">
            <a href="{{ route('auth.google') }}" class="btn btn-outline-primary">
                <i class="fab fa-google"></i> Увійти через Google
            </a>
        </div>
    </div>
@endsection
