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
</head>
<body>
@include('layouts.navigation')

<div class="container-fluid">
    <div class="row">
        @if(Route::is('admin.*'))
            @include('layouts.partials.sidebar')
            <main class="col-md-10 offset-md-2 px-md-4 py-3 bg-light">
                @yield('content')
            </main>
        @else
            <main class="col-12 px-md-4 py-3 bg-light">
                @yield('content')
            </main>
        @endif
    </div>
</div>

<footer class="bg-dark text-center py-3 mt-4 text-light">
    <p>© 2025 StyleHub. Усі права захищено.</p>
    <p>Facebook | Instagram | Контакти</p>
</footer>

<!-- Bootstrap JS через CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
@yield('scripts')
</body>
</html>
