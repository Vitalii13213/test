@extends('layouts.main')

@section('title', 'Товари - Адмін')

@section('content')
    <div class="container-fluid">
        <h2>Товари</h2>
        <div class="mb-3">
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Додати товар</a>
            <a href="{{ route('admin.products.index', ['show_inactive' => !$showInactive, 'category_id' => $categoryId]) }}" class="btn btn-secondary">
                {{ $showInactive ? 'Показати лише активні' : 'Показати неактивні' }}
            </a>
            <form class="d-inline-block ms-3" method="GET" action="{{ route('admin.products.index') }}">
                <select name="category_id" class="form-select d-inline-block w-auto" onchange="this.form.submit()">
                    <option value="">Усі категорії</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $categoryId == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                <input type="hidden" name="show_inactive" value="{{ $showInactive ? '1' : '0' }}">
            </form>
        </div>
        @if($products->isEmpty())
            <p>Товари відсутні.</p>
        @else
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Назва</th>
                    <th>Категорія</th>
                    <th>Ціна</th>
                    <th>Наявність</th>
                    <th>Кольори</th>
                    <th>Розміри</th>
                    <th>Статус</th>
                    <th>Дії</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ number_format($product->price, 2) }} грн</td>
                        <td>{{ $product->stock }}</td>
                        <td>
                            @foreach ($product->colors as $color)
                                <span style="display: inline-block; width: 15px; height: 15px; background-color: {{ $color->hex ?? '#ffffff' }}; border: 1px solid #ddd;"></span>
                                {{ $color->name }}
                            @endforeach
                        </td>
                        <td>{{ $product->sizes->pluck('name')->join(', ') }}</td>
                        <td>
                            <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $product->is_active ? 'Активний' : 'Неактивний' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.products.edit', $product->id) }}?show_inactive={{ $showInactive ? '1' : '0' }}&category_id={{ $categoryId }}" class="btn btn-sm btn-warning">Редагувати</a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Ви впевнені?')">Видалити</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
