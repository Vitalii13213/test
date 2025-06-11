@extends('layouts.main')

@section('title', 'Замовлення #' . $order->id)

@section('content')
    <div class="container-fluid">
        <h2>Замовлення #{{ $order->id }}</h2>
        <p><strong>Користувач:</strong> {{ $order->user->email }}</p>
        <p><strong>Сума:</strong> {{ number_format($order->total_amount, 2) }} грн</p>
        <p><strong>Статус:</strong> {{ $order->status }}</p>
        <p><strong>Дата:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
        <p><strong>Доставка:</strong> {{ $order->city }}, {{ $order->delivery_point }} ({{ $order->delivery_type }})</p>
        <p><strong>Одержувач:</strong> {{ $order->surname }} {{ $order->name }} {{ $order->patronymic }}</p>
        <p><strong>Телефон:</strong> {{ $order->phone_number }}</p>

        <h3>Товари</h3>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Товар</th>
                <th>Колір</th>
                <th>Розмір</th>
                <th>Ціна</th>
                <th>Кількість</th>
                <th>Сума</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->pivot->color_id ? \App\Models\Color::find($product->pivot->color_id)->name : '—' }}</td>
                    <td>{{ $product->pivot->size_id ? \App\Models\Size::find($product->pivot->size_id)->name : '—' }}</td>
                    <td>{{ number_format($product->pivot->price, 2) }} грн</td>
                    <td>{{ $product->pivot->quantity }}</td>
                    <td>{{ number_format($product->pivot->price * $product->pivot->quantity, 2) }} грн</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <h3>Оновити статус</h3>
        <form method="POST" action="{{ route('admin.orders.update', $order->id) }}">
            @csrf
            @method('PATCH')
            <div class="mb-3">
                <label for="status" class="form-label">Статус</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Очікує</option>
                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Обробляється</option>
                    <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Відправлено</option>
                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Доставлено</option>
                    <option value="canceled" {{ $order->status === 'canceled' ? 'selected' : '' }}>Скасовано</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Оновити</button>
        </form>
    </div>
@endsection
