@extends('layouts.main')

@section('title', 'Кастомізація {{ $product->name }} - StyleHub')

@section('content')
    <div class="container">
        <h2>Кастомізація {{ $product->name }}</h2>
        <div class="row">
            <div class="col-md-6">
                @if($product->image_path)
                    <img src="{{ asset($product->image_path) }}" class="img-fluid" alt="{{ $product->name }}">
                @else
                    <img src="https://via.placeholder.com/300" class="img-fluid" alt="{{ $product->name }}">
                @endif
            </div>
            <div class="col-md-6">
                <form action="{{ route('products.storeCustomize', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="design" class="form-label">Завантажте ваш принт</label>
                        <input type="file" class="form-control @error('design') is-invalid @enderror" id="design" name="design" accept="image/*" required>
                        @error('design')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Додати до кошика</button>
                </form>
            </div>
        </div>
    </div>
@endsection
