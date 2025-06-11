@extends('layouts.main')

@section('title', 'Адмін-панель')

@section('content')
    <div class="container-fluid">
        <h2>Адмін-панель</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Категорії</h5>
                        <p class="card-text">Керування категоріями товарів.</p>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">Переглянути</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Товари</h5>
                        <p class="card-text">Керування товарами.</p>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-primary">Переглянути</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Замовлення</h5>
                        <p class="card-text">Керування замовленнями.</p>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-primary">Переглянути</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
