@extends('layouts.main')

@section('title', 'Додати колір - Адмін')

@section('content')
    <div class="container-fluid">
        <h2>Додати колір</h2>
        <form method="POST" action="{{ route('admin.color.store') }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Назва</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="hex" class="form-label">Колір</label>
                <input type="color" name="hex" id="hex" class="form-control form-control-color" value="{{ old('hex', '#ffffff') }}" required>
                @error('hex')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Зберегти</button>
        </form>
    </div>
@endsection
