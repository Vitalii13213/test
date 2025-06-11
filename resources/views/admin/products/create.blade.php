@extends('layouts.main')

@section('title', 'Додати товар - Адмін')

@section('content')
    <div class="container-fluid">
        <h2>Додати товар</h2>
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Назва</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Опис</label>
                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                @error('description')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Ціна</label>
                <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}" step="0.01" required>
                @error('price')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">Наявність</label>
                <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock') }}" required>
                @error('stock')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Категорія</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Зображення</label>
                <input type="file" name="image" id="image" class="form-control">
                @error('image')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Кольори</label>
                <div class="d-flex flex-wrap">
                    @foreach ($colors as $color)
                        <div class="form-check me-3">
                            <input type="checkbox" name="colors[]" id="color_{{ $color->id }}" value="{{ $color->id }}" class="form-check-input" {{ in_array($color->id, old('colors', [])) ? 'checked' : '' }}>
                            <label for="color_{{ $color->id }}" class="form-check-label" style="background-color: {{ $color->hex ?? '#ffffff' }}; width: 30px; height: 30px; display: inline-block; border: 1px solid #ddd;" title="{{ $color->name }}"></label>
                            <span>{{ $color->name }}</span>
                        </div>
                    @endforeach
                </div>
                @error('colors')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Розміри</label>
                <div class="d-flex flex-wrap">
                    @foreach ($sizes as $size)
                        <div class="form-check me-3">
                            <input type="checkbox" name="sizes[]" id="size_{{ $size->id }}" value="{{ $size->id }}" class="form-check-input" {{ in_array($size->id, old('sizes', [])) ? 'checked' : '' }}>
                            <label for="size_{{ $size->id }}" class="form-check-label">{{ $size->name }}</label>
                        </div>
                    @endforeach
                </div>
                @error('sizes')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="is_active" class="form-label">Статус</label>
                <select name="is_active" id="is_active" class="form-control" required>
                    <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Активний</option>
                    <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Неактивний</option>
                </select>
                @error('is_active')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Зберегти</button>
        </form>
    </div>
@endsection
