@extends('layouts.main')

@section('title', 'Головна - StyleHub')

@section('content')
    <section class="hero text-center mb-5">
        <h1>Створи свій унікальний стиль!</h1>
        <p>Обирай одяг або створюй футболки з власними принтами.</p>
        <a href="{{ route('categories.show', 1) }}" class="btn btn-primary">Кастомізувати</a>
    </section>

    <section class="popular-products mb-5">
        <h2>Популярні товари</h2>
        <div class="row">
            @foreach($popularProducts as $product)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        @if($product->image_path)
                            <img src="{{ asset($product->image_path) }}" class="card-img-top" alt="{{ $product->name }}">
                        @else
                            <img src="https://via.placeholder.com/150" class="card-img-top" alt="{{ $product->name }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->category->name ?? '—' }}</p>
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
    </section>

    <section class="all-products">
        <h2>Усі товари</h2>
        <div class="filters mb-4">
            <div class="row">
                <div class="col-md-3">
                    <label>Категорії</label>
                    <select class="form-control filter" data-filter="category">
                        <option value="">Усі категорії</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Кольори</label>
                    <select class="form-control filter" data-filter="color">
                        <option value="">Усі кольори</option>
                        @foreach($colors as $color)
                            <option value="{{ $color }}">{{ $color }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Розміри</label>
                    <select class="form-control filter" data-filter="size">
                        <option value="">Усі розміри</option>
                        @foreach($sizes as $size)
                            <option value="{{ $size }}">{{ $size }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Сортування</label>
                    <select class="form-control filter" data-filter="sort">
                        <option value="">За замовчуванням</option>
                        <option value="latest">Найновіші</option>
                    </select>
                </div>
            </div>
            <button class="btn btn-primary mt-2" id="applyFilters">Фільтрувати</button>
        </div>
        <div class="row" id="productsList">
            @foreach($products as $product)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        @if($product->image_path)
                            <img src="{{ asset($product->image_path) }}" class="card-img-top" alt="{{ $product->name }}">
                        @else
                            <img src="https://via.placeholder.com/150" class="card-img-top" alt="{{ $product->name }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->category->name ?? '—' }}</p>
                            <p class="card-text">{{ number_format($product->price, 2) }} грн</p>
                            <p class="card-text">Колір: {{ $product->attributes->isNotEmpty() ? $product->attributes->pluck('color')->filter()->implode(', ') : 'Немає' }}</p>
                            <p class="card-text">Розмір: {{ $product->attributes->isNotEmpty() ? $product->attributes->pluck('size')->filter()->implode(', ') : 'Немає' }}</p>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary">Детальніше</a>
                            @if($product->category->name === 'Футболки')
                                <a href="{{ route('products.customize', $product->id) }}" class="btn btn-outline-secondary">Кастомізувати</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        document.getElementById('applyFilters').addEventListener('click', function() {
            const filters = {};
            document.querySelectorAll('.filter').forEach(filter => {
                if (filter.value) {
                    filters[filter.dataset.filter] = filter.value;
                }
            });
            fetch('{{ route('products.filter') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(filters)
            })
                .then(response => response.json())
                .then(data => {
                    const productsList = document.getElementById('productsList');
                    productsList.innerHTML = '';
                    data.forEach(product => {
                        productsList.innerHTML += `
                            <div class="col-md-3 mb-4">
                                <div class="card h-100">
                                    <img src="${product.image_path || 'https://via.placeholder.com/150'}" class="card-img-top" alt="${product.name}">
                                    <div class="card-body">
                                        <h5 class="card-title">${product.name}</h5>
                                        <p class="card-text">${product.category_name || '—'}</p>
                                        <p class="card-text">${product.price} грн</p>
                                        <p class="card-text">Колір: ${product.attributes.map(attr => attr.color).join(', ') || 'Немає'}</p>
                                        <p class="card-text">Розмір: ${product.attributes.map(attr => attr.size).join(', ') || 'Немає'}</p>
                                        <a href="/products/${product.id}" class="btn btn-outline-primary">Детальніше</a>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
@endsection
