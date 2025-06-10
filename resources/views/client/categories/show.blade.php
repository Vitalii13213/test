@extends('layouts.main')

@section('title', '{{ $category->name }} - StyleHub')

@section('content')
    <div class="container">
        <h2>{{ $category->name }}</h2>
        @if($category->description)
            <p>{{ $category->description }}</p>
        @endif
        @if($category->products->isEmpty())
            <p>У цій категорії поки немає товарів.</p>
        @else
            <div class="row">
                @foreach($category->products as $product)
                    <div class="col-md-3 mb-4">
                        <div class="card h-100">
                            @if($product->image_path)
                                <img src="{{ asset($product->image_path) }}" class="card-img-top" alt="{{ $product->name }}">
                            @else
                                <img src="https://via.placeholder.com/150" class="card-img-top" alt="{{ $product->name }}">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ number_format($product->price, 2) }} грн</p>
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary">Детальніше</a>
                                @if($product->category->name === 'Футболки')
                                    <a href="{{ route('products.customize', $product->id) }}" class="btn btn-outline-secondary">Кастомізувати</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
