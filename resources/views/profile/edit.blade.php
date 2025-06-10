@extends('layouts.main')

@section('title', 'Редагувати профіль')

@section('content')
    <h3>Редагувати профіль</h3>
    @if(session('status') === 'profile-updated')
        <div class="alert alert-success">Профіль оновлено.</div>
    @endif
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Ім'я</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Телефон</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
        </div>
        <div class="mb-3">
            <label for="full_name" class="form-label">ПІБ</label>
            <input type="text" name="full_name" id="full_name" class="form-control" value="{{ old('full_name', $user->full_name) }}">
        </div>
        <div class="mb-3">
            <label for="city" class="form-label">Населений пункт</label>
            <input type="text" name="city" id="city" class="form-control" value="{{ old('city', $user->city) }}">
        </div>
        <div class="mb-3">
            <label for="nova_poshta_branch" class="form-label">Улюблене відділення Нової Пошти</label>
            <input type="text" name="nova_poshta_branch" id="nova_poshta_branch" class="form-control" value="{{ old('nova_poshta_branch', $user->nova_poshta_branch) }}">
        </div>
        <button type="submit" class="btn btn-primary">Зберегти</button>
    </form>

    <hr>
    <h4>Видалити профіль</h4>
    <form action="{{ route('profile.destroy') }}" method="POST">
        @csrf
        @method('DELETE')
        <div class="mb-3">
            <label for="password" class="form-label">Пароль</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-danger">Видалити профіль</button>
    </form>
@endsection
