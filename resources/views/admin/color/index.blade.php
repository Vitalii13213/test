@extends('layouts.main')

@section('title', 'Кольори')

@section('content')
    <div class="container">
        <h3>Кольори</h3>
        <a href="{{ route('admin.color.create') }}" class="btn btn-primary mb-3">Додати колір</a>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if ($colors->isEmpty())
            <p>Кольори відсутні.</p>
        @else
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Назва</th>
                    <th>HEX</th>
                    <th>Дії</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($colors as $color)
                    <tr>
                        <td>{{ $color->id }}</td>
                        <td>{{ $color->name }}</td>
                        <td>
                            <span style="width: 20px; height: 20px; background-color: {{ $color->hex }}; display: inline-block; border: 1px solid #ccc;"></span>
                            {{ $color->hex }}
                        </td>
                        <td>
                            <a href="{{ route('admin.color.edit', $color->id) }}" class="btn btn-warning btn-sm">Редагувати</a>
                            <form action="{{ route('admin.color.destroy', $color->id) }}" method="POST" style="display: inline;">
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
