@extends('layouts.main')

@section('title', $product->name)

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                @if ($product->image_path)
                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="img-fluid">
                @else
                    <img src="{{ asset('images/placeholder.jpg') }}" alt="Placeholder" class="img-fluid">
                @endif
            </div>
            <div class="col-md-6">
                <h2>{{ $product->name }}</h2>
                <p>{{ $product->description }}</p>
                <p><strong>Ціна:</strong> {{ number_format($product->price, 2) }} грн</p>
                <form action="{{ route('cart.store', $product->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Колір</label>
                        <div class="d-flex flex-wrap">
                            @foreach ($product->colors as $color)
                                <div class="form-check me-3">
                                    <input class="form-check-input color-radio" type="radio" name="color_id" id="color_{{ $color->id }}" value="{{ $color->id }}" {{ request()->color_id == $color->id ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="color_{{ $color->id }}" style="background-color: {{ $color->hex ?? '#ffffff' }}; width: 30px; height: 30px; display: inline-block; border: 2px solid {{ request()->color_id == $color->id ? '#000' : '#ddd' }};" title="{{ $color->name }}"></label>
                                </div>
                            @endforeach
                        </div>
                        @error('color_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="size_id" class="form-label">Розмір</label>
                        <select name="size_id" id="size_id" class="form-control" required>
                            @foreach ($product->sizes as $size)
                                <option value="{{ $size->id }}">{{ $size->name }}</option>
                            @endforeach
                        </select>
                        @error('size_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Кількість</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" required>
                        @error('quantity')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Додати до кошика</button>
                </form>
                <a href="{{ route('products.customize', $product->id) }}" class="btn btn-secondary mt-3">Кастомізувати</a>
            </div>
        </div>
    </div>

    <style>
        .color-radio {
            display: none;
        }
        .form-check-label:hover {
            border-color: #000 !important;
        }
        .form-check-input:checked + .form-check-label {
            border-color: #000 !important;
        }
    </style>
@endsection
