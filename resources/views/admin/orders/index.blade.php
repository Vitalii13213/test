@extends('layouts.main')

@section('title', 'Замовлення - Адмін')

@section('content')
    <div class="container-fluid">
        <h2>Замовлення</h2>
        @if($orders->isEmpty())
            <p>Замовлення відсутні.</p>
        @else
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Користувач</th>
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
                        <td>{{ $order->user->email }}</td>
                        <td>{{ number_format($order->total_amount, 2) }} грн</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info">Переглянути</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
