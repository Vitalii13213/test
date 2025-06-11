@extends('layouts.main')

@section('title', 'Кошик')

@section('content')
    <div class="container">
        <h2>Кошик</h2>
        @if (empty($cart))
            <p>Ваш кошик порожній.</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary">Продовжити покупки</a>
        @else
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Товар</th>
                    <th>Колір</th>
                    <th>Розмір</th>
                    <th>Ціна</th>
                    <th>Кількість</th>
                    <th>Сума</th>
                    <th>Дії</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($cart as $cartKey => $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>
                            <span style="display: inline-block; width: 20px; height: 20px; background-color: {{ $item['color_hex'] ?? '#ffffff' }}; border: 1px solid #ddd;"></span>
                            {{ $item['color_name'] }}
                        </td>
                        <td>{{ $item['size_name'] }}</td>
                        <td>{{ number_format($item['price'], 2) }} грн</td>
                        <td>
                            <div class="quantity-control">
                                <form action="{{ route('cart.update', $cartKey) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-outline-secondary btn-sm" name="quantity" value="{{ $item['quantity'] - 1 }}" {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>-</button>
                                    <span class="quantity">{{ $item['quantity'] }}</span>
                                    <button type="submit" class="btn btn-outline-secondary btn-sm" name="quantity" value="{{ $item['quantity'] + 1 }}" {{ $item['quantity'] >= ($item['stock'] ?? 1000) ? 'disabled' : '' }}>+</button>
                                </form>
                            </div>
                        </td>
                        <td>{{ number_format($item['price'] * $item['quantity'], 2) }} грн</td>
                        <td>
                            <form action="{{ route('cart.remove', $cartKey) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Видалити</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <p>Загальна сума: {{ number_format($total, 2) }} грн</p>
            <div class="d-flex justify-content-between">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Продовжити покупки</a>
                <a href="{{ route('checkout.create') }}" class="btn btn-primary">Оформити замовлення</a>
            </div>
        @endif
    </div>

    <style>
        .quantity-control {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .quantity {
            min-width: 30px;
            text-align: center;
        }
        .btn-sm {
            padding: 2px 8px;
        }
    </style>
@endsection
