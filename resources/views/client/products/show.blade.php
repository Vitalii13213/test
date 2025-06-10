@extends('layouts.main')

@section('title', $product->name)

@section('content')
    <div class="container">
        <h3>{{ $product->name }}</h3>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="row">
            <div class="col-md-6">
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid" style="max-height: 400px; object-fit: cover;">
                @else
                    <img src="https://via.placeholder.com/400" alt="Placeholder" class="img-fluid" style="max-height: 400px; object-fit: cover;">
                @endif
            </div>
            <div class="col-md-6">
                <p><strong>Ціна:</strong> {{ $product->price }} грн</p>
                <p><strong>Опис:</strong> {{ $product->description ?? 'Немає опису' }}</p>
                <p><strong>Наявність:</strong> {{ $product->stock > 0 ? 'В наявності (' . $product->stock . ' шт.)' : 'Немає в наявності' }}</p>
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    @if ($product->colors->isNotEmpty())
                        <div class="mb-3">
                            <label for="color_id" class="form-label">Колір</label>
                            <div class="d-flex flex-wrap">
                                @foreach ($product->colors as $color)
                                    <div class="form-check me-2">
                                        <input type="radio" name="color_id" id="color_{{ $color->id }}" value="{{ $color->id }}" class="d-none color-radio" {{ $loop->first ? 'checked' : '' }}>
                                        <label for="color_{{ $color->id }}" class="color-swatch" style="width: 30px; height: 30px; background-color: {{ $color->hex }}; border: 1px solid #ccc; display: block; cursor: pointer;" title="{{ $color->name }}"></label>
                                    </div>
                                @endforeach
                            </div>
                            @error('color_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="size_id" class="form-label">Розмір</label>
                        <select name="size_id" id="size_id" class="form-control" required>
                            <option value="">Виберіть розмір</option>
                            @foreach ($product->sizes as $size)
                                <option value="{{ $size->id }}">{{ $size->name }}</option>
                            @endforeach
                            @error('size_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Кількість</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" max="{{ $product->stock }}" required>
                        @error('quantity')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    @if ($product->stock > 0)
                        <button type="submit" class="btn btn-primary">Додати до кошика</button>
                    @else
                        <button type="button" class="btn btn-secondary" disabled>Немає в наявності</button>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .color-swatch {
            transition: all 0.2s ease;
        }
        .color-radio:checked + .color-swatch {
            border: 2px solid #000;
            transform: scale(1.2);
        }
    </style>
@endsection

@section('scripts')
    <script>
        document.querySelectorAll('.color-radio').forEach(radio => {
            radio.addEventListener('change', () => {
                document.querySelectorAll('.color-swatch').forEach(swatch => {
                    swatch.style.border = '1px solid #ccc';
                    swatch.style.transform = 'scale(1)';
                });
                const selectedSwatch = radio.nextElementSibling;
                selectedSwatch.style.border = '2px solid #000';
                selectedSwatch.style.transform = 'scale(1.2)';
            });
        });
    </script>
@endsection
