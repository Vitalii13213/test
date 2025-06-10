@extends('layouts.main')

@section('title', 'Замовлення')

@section('content')
    <div class="container">
        <h3>Замовлення</h3>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($orders->isEmpty())
            <p>Замовлення відсутні.</p>
        @else
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Клієнт</th>
                    <th>Телефон</th>
                    <th>Сума</th>
                    <th>Статус</th>
                    <th>Дата</th>
                    <th>Дія</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->customer }}</td>
                        <td>{{ $order->phone }}</td>
                        <td>{{ $order->total }} грн</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->date ? $order->date->format('d.m.Y H:i') : 'Н/Д' }}</td>
                        <td>
                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Видалити</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $orders->links() }}
        @endif
    </div>
@endsection
