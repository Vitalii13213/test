@extends('main')

@section('title', 'Products')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title">Products</h4>
                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add Product</a>
                    </div>
                    <p class="card-description">List of clothing products</p>
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
                                <th>ID</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product['id'] }}</td>
                                    <td>{{ $product['name'] }}</td>
                                    <td>{{ $product['category'] }}</td>
                                    <td>${{ number_format($product['price'], 2) }}</td>
                                    <td>{{ $product['stock'] }}</td>
                                    <td>
                                        <a href="{{ route('admin.products.edit', $product['id']) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('admin.products.destroy', $product['id']) }}" method="POST" style="display:inline;">
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
