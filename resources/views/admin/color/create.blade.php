@extends('layouts.main')

@section('title', 'Додати колір')

@section('content')
    <div class="container">
        <h3>Додати колір</h3>
        <form action="{{ route('admin.color.store') }}" method="POST">
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
                <div class="d-flex align-items-center">
                    <input type="color" name="hex" id="hex" value="{{ old('hex', '#FFFFFF') }}" required>
                    <input type="text" id="hex-text" class="form-control ms-2" value="{{ old('hex', '#FFFFFF') }}" readonly>
                </div>
                @error('hex')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Додати</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        const colorPicker = document.getElementById('hex');
        const hexText = document.getElementById('hex-text');
        colorPicker.addEventListener('input', () => {
            hexText.value = colorPicker.value.toUpperCase();
        });
    </script>
@endsection
