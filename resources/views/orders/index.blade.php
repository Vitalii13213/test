@extends('main')

@section('title', 'Orders')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Orders</h4>
                    <p class="card-description">List of customer orders for clothing store</p>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Phone</th>
                                <th>Shipment Description</th>
                                <th>Weight (kg)</th>
                                <th>Dimensions (cm)</th>
                                <th>City</th>
                                <th>Delivery Point</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order['id'] }}</td>
                                    <td>{{ $order['customer'] }}</td>
                                    <td>{{ $order['phone'] }}</td>
                                    <td>{{ $order['shipment_description'] }}</td>
                                    <td>{{ number_format($order['weight'], 2) }}</td>
                                    <td>{{ $order['length'] }}x{{ $order['width'] }}x{{ $order['height'] }}</td>
                                    <td>{{ $order['city'] }}</td>
                                    <td>{{ $order['delivery_point'] }}</td>
                                    <td>${{ number_format($order['total'], 2) }}</td>
                                    <td>{{ $order['status'] }}</td>
                                    <td>{{ $order['date'] }}</td>
                                    <td>
                                        <form action="{{ route('admin.orders.destroy', $order['id']) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
