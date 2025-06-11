@extends('layouts.main')

@section('title', 'Товари - StyleHub')

@section('content')
    <div class="container">
        <h2>Товари</h2>
        @if($products->isEmpty())
            <p>Товари відсутні.</p>
        @else
            <div class="row">
                @foreach($products as $product)
                    <div class="col-md-3 mb-4">
                        <div class="card h-100">
                            @if($product->image_path)
                                <img src="{{ asset($product->image_path) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                            @else
                                <img src="https://via.placeholder.com/150" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ $product->category->name ?? '—' }}</p>
                                <p class="card-text">{{ number_format($product->price, 2) }} грн</p>
                                <div class="mb-2">
                                    <small>Кольори:</small>
                                    <div class="d-flex flex-wrap">
                                        @foreach ($product->colors as $color)
                                            <span style="width: 20px; height: 20px; background-color: {{ $color->hex }}; display: inline-block; border: 1px solid #ccc; margin-right: 4px;" title="{{ $color->name }}"></span>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <small>Розміри:</small>
                                    <div class="d-flex flex-wrap">
                                        @foreach ($product->sizes as $size)
                                            <span class="badge bg-secondary me-1">{{ $size->name }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary">Детальніше</a>
                                @if($product->category->name === 'Футболки')
                                    <a href="{{ route('products.customize', $product->id) }}" class="btn btn-outline-secondary">Кастомізувати</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $products->links() }}
        @endif
    </div>
@endsection
