@extends('layouts.main')

@section('title', 'Розміри')

@section('content')
    <div class="container">
        <h3>Розміри</h3>
        <a href="{{ route('admin.sizes.create') }}" class="btn btn-primary mb-3">Додати розмір</a>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if ($sizes->isEmpty())
            <p>Розміри відсутні.</p>
        @else
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Назва</th>
                    <th>Дії</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($sizes as $size)
                    <tr>
                        <td>{{ $size->id }}</td>
                        <td>{{ $size->name }}</td>
                        <td>
                            <a href="{{ route('admin.sizes.edit', $size->id) }}" class="btn btn-warning btn-sm">Редагувати</a>
                            <form action="{{ route('admin.sizes.destroy', $size->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Ви впевнені?')">Видалити</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
