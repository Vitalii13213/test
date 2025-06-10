<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <!-- Bootstrap CSS через CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous">
    @yield('styles')
</head>
<body>
@include('layouts.navigation')

<div class="container-fluid">
    <div class="row">
        @if (Route::is('admin.*'))
            @include('layouts.partials.sidebar')
            <main class="col-md-10 offset-md-2 px-md-4 py-3 bg-light">
                @yield('content')
            </main>
        @else
            <main class="col-12 px-md-4 py-3 bg-light">
                @if (Route::is('home'))
                    <div class="container">
                        <h3>Вітаємо в StyleHub!</h3>
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5>Категорії</h5>
                                <div class="d-flex flex-wrap">
                                    @foreach ($categories as $category)
                                        <a href="{{ route('categories.show', $category->id) }}" class="btn btn-outline-primary me-2 mb-2">{{ $category->name }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @if ($products->isEmpty())
                                <p>Товари відсутні.</p>
                            @else
                                @foreach ($products as $product)
                                    <div class="col-md-3 mb-4">
                                        <div class="card h-100">
                                            @if ($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                                            @else
                                                <img src="https://via.placeholder.com/300" class="card-img-top" alt="Placeholder" style="height: 200px; object-fit: cover;">
                                            @endif
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $product->name }}</h5>
                                                <p class="card-text">{{ $product->price }} грн</p>
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
                                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">Детальніше</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @else
                    @yield('content')
                @endif
            </main>
        @endif
    </div>
</div>

<footer class="bg-dark text-light text-center py-3 mt-4">
    <p>© 2025 StyleHub. Усі права захищено.</p>
    <p>Facebook | Instagram | Контакти</p>
</footer>
<!-- Bootstrap JS через CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
@yield('scripts')
</body>
</html>
