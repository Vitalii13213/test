@extends('layouts.main')

@section('title', 'Замовлення - Адмін-панель')

@section('content')
    <div class="container">
        <h2>Замовлення</h2>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($orders->isEmpty())
            <p>Немає замовлень.</p>
        @else
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Клієнт</th>
                        <th>Телефон</th>
                        <th>Місто</th>
                        <th>Пункт доставки</th>
                        <th>Сума</th>
                        <th>Статус</th>
                        <th>Дата</th>
                        <th>Дії</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->customer }}</td>
                            <td>{{ $order->phone }}</td>
                            <td>{{ $order->city }}</td>
                            <td>{{ $order->delivery_point }}</td>
                            <td>{{ number_format($order->total, 2) }} грн</td>
                            <td>{{ $order->status }}</td>
                            <td>{{ $order->date->format('d.m.Y H:i') }}</td>
                            <td>
                                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Ви впевнені?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Видалити</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
