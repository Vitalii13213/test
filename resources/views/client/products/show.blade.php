@extends('layouts.main')

@section('title', '{{ $product->name }} - StyleHub')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                @if($product->image_path)
                    <img src="{{ asset($product->image_path) }}" class="img-fluid" alt="{{ $product->name }}">
                @else
                    <img src="https://via.placeholder.com/300" class="img-fluid" alt="{{ $product->name }}">
                @endif
            </div>
            <div class="col-md-6">
                <h2>{{ $product->name }}</h2>
                <p>Категорія: {{ $product->category->name ?? '—' }}</p>
                <p>Ціна: {{ number_format($product->price, 2) }} грн</p>
                <p>Колір: {{ $product->attributes->isNotEmpty() ? $product->attributes->pluck('color')->filter()->implode(', ') : 'Немає' }}</p>
                <p>Розмір: {{ $product->attributes->isNotEmpty() ? $product->attributes->pluck('size')->filter()->implode(', ') : 'Немає' }}</p>
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Кількість:</label>
                        <input type="number" class="form-control w-25" id="quantity" name="quantity" value="1" min="1">
                    </div>
                    <button type="submit" class="btn btn-primary">Додати до кошика</button>
                    @if($product->category->name === 'Футболки')
                        <a href="{{ route('products.customize', $product->id) }}" class="btn btn-outline-secondary">Кастомізувати</a>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection
