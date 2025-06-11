@extends('layouts.main')

@section('title', 'Товари')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Бічна панель із фільтрами -->
            <div class="col-md-3">
                <h4>Фільтри</h4>
                <form method="GET" action="{{ route('products.index') }}" id="filterForm">
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Категорія</label>
                        <select name="category_id" id="category_id" class="form-select">
                            <option value="">Усі категорії</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request()->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="color_id" class="form-label">Колір</label>
                        <select name="color_id" id="color_id" class="form-select">
                            <option value="">Усі кольори</option>
                            @foreach($colors as $color)
                                <option value="{{ $color->id }}" {{ request()->color_id == $color->id ? 'selected' : '' }}>{{ $color->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="size_id" class="form-label">Розмір</label>
                        <select name="size_id" id="size_id" class="form-select">
                            <option value="">Усі розміри</option>
                            @foreach($sizes as $size)
                                <option value="{{ $size->id }}" {{ request()->size_id == $size->id ? 'selected' : '' }}>{{ $size->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ціна (грн)</label>
                        <div id="priceSlider" class="mb-3"></div>
                        <div class="input-group">
                            <input type="number" class="form-control" id="minPriceInput" name="min_price" value="{{ request()->min_price ?? $minPrice }}" min="{{ $minPrice }}" step="1">
                            <span class="input-group-text">—</span>
                            <input type="number" class="form-control" id="maxPriceInput" name="max_price" value="{{ request()->max_price ?? $maxPrice }}" min="{{ $minPrice }}" max="{{ $maxPrice }}" step="1">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="sort" class="form-label">Сортування</label>
                        <select name="sort" id="sort" class="form-select" onchange="this.form.submit()">
                            <option value="name_asc" {{ request()->sort == 'name_asc' ? 'selected' : '' }}>За назвою (А-Я)</option>
                            <option value="name_desc" {{ request()->sort == 'name_desc' ? 'selected' : '' }}>За назвою (Я-А)</option>
                            <option value="price_asc" {{ request()->sort == 'price_asc' ? 'selected' : '' }}>За ціною (зростання)</option>
                            <option value="price_desc" {{ request()->sort == 'price_desc' ? 'selected' : '' }}>За ціною (спадання)</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Застосувати</button>
                </form>
            </div>
            <!-- Список товарів -->
            <div class="col-md-9">
                <h2>Товари</h2>
                <div class="row">
                    @if($products->isEmpty())
                        <p>Товари не знайдено.</p>
                    @else
                        @foreach($products as $product)
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    @if ($product->image_path)
                                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="card-img-top">
                                    @else
                                        <img src="{{ asset('images/placeholder.jpg') }}" alt="Placeholder" class="card-img-top">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->name }}</h5>
                                        <p class="card-text">{{ number_format($product->price, 2) }} грн</p>
                                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">Переглянути</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        {{ $products->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Підключення noUISlider -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nouislider@15.8.1/dist/nouislider.min.css">
    <script src="https://cdn.jsdelivr.net/npm/nouislider@15.8.1/dist/nouislider.min.js"></script>

    <style>
        #priceSlider {
            margin: 20px 10px;
        }
        .noUi-target {
            border: none;
            box-shadow: none;
        }
        .noUi-connect {
            background: #007bff;
        }
        .noUi-handle {
            border: 1px solid #007bff;
            background: #fff;
            box-shadow: 0 0 5px rgba(0,0,0,0.2);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const slider = document.getElementById('priceSlider');
            const minPriceInput = document.getElementById('minPriceInput');
            const maxPriceInput = document.getElementById('maxPriceInput');

            noUiSlider.create(slider, {
                start: [{{ request()->min_price ?? $minPrice }}, {{ request()->max_price ?? $maxPrice }}],
                connect: true,
                range: {
                    'min': {{ $minPrice }},
                    'max': {{ $maxPrice }}
                },
                step: 1
            });

            slider.noUiSlider.on('update', function (values, handle) {
                minPriceInput.value = Math.round(values[0]);
                maxPriceInput.value = Math.round(values[1]);
            });

            minPriceInput.addEventListener('change', function () {
                slider.noUiSlider.set([this.value, null]);
            });

            maxPriceInput.addEventListener('change', function () {
                slider.noUiSlider.set([null, this.value]);
            });
        });
    </script>
@endsection
