@extends('layouts.main')

@section('title', 'Кошик')

@section('content')
    <div class="container">
        <h3>Кошик</h3>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if (!empty($cart))
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Товар</th>
                    <th>Колір</th>
                    <th>Розмір</th>
                    <th>Ціна</th>
                    <th>Кількість</th>
                    <th>Сума</th>
                    <th>Дія</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($cart as $cartKey => $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>
                            <div style="width: 20px; height: 20px; background-color: {{ $item['color_hex'] }}; border: 1px solid #ccc; display: inline-block;"></div>
                            {{ $item['color_name'] }}
                        </td>
                        <td>{{ $item['size_name'] }}</td>
                        <td>{{ $item['price'] }} грн</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>{{ $item['price'] * $item['quantity'] }} грн</td>
                        <td>
                            <form action="{{ route('cart.remove', $cartKey) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Видалити</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <p><strong>Загальна сума: {{ array_sum(array_map(fn ($item) => $item['price'] * $item['quantity'], $cart)) }} грн</strong></p>
            <a href="{{ route('checkout.create') }}" class="btn btn-primary">Оформити замовлення</a>
            <a href="{{ route('cart.clear') }}" class="btn btn-secondary">Очистити кошик</a>
        @else
            <p>Кошик порожній.</p>
        @endif
    </div>
@endsection
