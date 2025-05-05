@extends('main')

@section('title', 'Edit Product')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Product</h4>
                    <form action="{{ route('admin.products.update', $product['id']) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product['name']) }}" required>
                            @error('name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-control" id="category" name="category" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category['name'] }}" {{ old('category', $product['category']) == $category['name'] ? 'selected' : '' }}>{{ $category['name'] }}</option>
                                @endforeach
                            </select>
                            @error('category')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price ($)</label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price', $product['price']) }}" required>
                            @error('price')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $product['stock']) }}" required>
                            @error('stock')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Update Product</button>
                        <a href="{{ route('admin.products') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
