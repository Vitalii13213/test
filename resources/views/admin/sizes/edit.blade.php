@extends('layouts.main')

@section('title', 'Редагувати розмір - Адмін')

@section('content')
    <div class="container-fluid">
        <h2>Редагувати розмір</h2>
        <form method="POST" action="{{ route('admin.sizes.update', $size->id) }}">
            @csrf
            @method('PATCH')
            <div class="mb-3">
                <label for="name" class="form-label">Назва</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $size->name) }}" required>
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Оновити</button>
        </form>
    </div>
@endsection
