@extends('layouts.main')

@section('title', 'Редагувати розмір')

@section('content')
    <div class="container">
        <h3>Редагувати розмір</h3>
        <form action="{{ route('admin.sizes.update', $size->id) }}" method="POST">
            @csrf
            @method('PUT')
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
