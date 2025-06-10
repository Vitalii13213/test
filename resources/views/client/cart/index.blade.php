@extends('layouts.main')

@section('title', 'Кошик - StyleHub')

@section('content')
    <div class="container">
        <h2>Кошик</h2>
        @if(!$products || $products->isEmpty())
            <p>Ваш кошик порожній.</p>
        @else
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Товар</th>
                        <th>Ціна</th>
                        <th>Кількість</th>
                        <th>Сума</th>
                        <th>Дії</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        @if(isset($cart[$product->id]))
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ number_format($product->price, 2) }} грн</td>
                                <td>{{ $cart[$product->id] }}</td>
                                <td>{{ number_format($product->price * $cart[$product->id], 2) }} грн</td>
                                <td>
                                    <form action="{{ route('cart.remove', $product->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Видалити</button>
                                    </form>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
            @if(Route::has('checkout'))
                <a href="{{ route('checkout') }}" class="btn btn-primary">Оформити замовлення</a>
            @endif
        @endif
    </div>
@endsection
