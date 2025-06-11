@extends('layouts.main')

@section('title', 'Додати розмір - Адмін')

@section('content')
    <div class="container-fluid">
        <h2>Додати розмір</h2>
        <form method="POST" action="{{ route('admin.sizes.store') }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Назва</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Зберегти</button>
        </form>
    </div>
@endsection
