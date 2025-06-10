@extends('layouts.main')

@section('title', 'Адмін-панель')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h1 class="h2">Панель керування</h1>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Товари</h5>
                    <p class="card-text">Кількість: {{ \App\Models\Product::count() }}</p>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-primary">Переглянути</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Замовлення</h5>
                    <p class="card-text">Кількість: {{ \App\Models\Order::count() }}</p>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-primary">Переглянути</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Категорії</h5>
                    <p class="card-text">Кількість: {{ \App\Models\Category::count() }}</p>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">Переглянути</a>
                </div>
            </div>
        </div>
    </div>
@endsection
