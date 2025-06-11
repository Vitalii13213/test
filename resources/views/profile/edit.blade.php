@extends('layouts.main')

@section('title', 'Профіль')

@section('content')
    <div class="container">
        <h2>Редагувати профіль</h2>

        @if (session('status') === 'profile-updated')
            <div class="alert alert-success">
                Профіль оновлено!
            </div>
        @endif

        @if (session('status') === 'password-updated')
            <div class="alert alert-success">
                Пароль оновлено!
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" class="mb-4">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label for="surname" class="form-label">Прізвище</label>
                <input type="text" name="surname" id="surname" class="form-control" value="{{ old('surname', $user->surname) }}" required>
                @error('surname')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="first_name" class="form-label">Ім'я</label>
                <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name', $user->first_name) }}" required>
                @error('first_name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="patronymic" class="form-label">По батькові</label>
                <input type="text" name="patronymic" id="patronymic" class="form-control" value="{{ old('patronymic', $user->patronymic) }}" required>
                @error('patronymic')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                @error('email')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Телефон</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                @error('phone')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="city" class="form-label">Місто</label>
                <input type="text" name="city" id="city" class="form-control" value="{{ old('city', $user->city) }}">
                @error('city')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="delivery_point" class="form-label">Пункт доставки</label>
                <input type="text" name="delivery_point" id="delivery_point" class="form-control" value="{{ old('delivery_point', $user->delivery_point) }}">
                @error('delivery_point')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Зберегти</button>
        </form>

        <h3>Змінити пароль</h3>
        <form method="POST" action="{{ route('profile.updatePassword') }}" class="mb-4">
            @csrf
            @method('PATCH')

            @if ($user->provider !== 'google' || $user->password)
                <div class="mb-3">
                    <label for="current_password" class="form-label">Поточний пароль</label>
                    <input type="password" name="current_password" id="current_password" class="form-control" required>
                    @error('current_password')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            @endif

            <div class="mb-3">
                <label for="password" class="form-label">Новий пароль</label>
                <input type="password" name="password" id="password" class="form-control" required>
                @error('password')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Підтвердження пароля</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Оновити пароль</button>
        </form>

        <h3>Видалити акаунт</h3>
        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')

            @if ($user->provider !== 'google' || $user->password)
                <div class="mb-3">
                    <label for="password" class="form-label">Пароль</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                    @error('password')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            @endif

            <button type="submit" class="btn btn-danger" onclick="return confirm('Ви впевнені?')">Видалити акаунт</button>
        </form>
    </div>
@endsection
