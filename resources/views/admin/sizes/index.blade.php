@extends('layouts.main')

@section('title', 'Розміри - Адмін')

@section('content')
    <div class="container-fluid">
        <h2>Розміри</h2>
        <div class="mb-3">
            <a href="{{ route('admin.sizes.create') }}" class="btn btn-primary">Додати розмір</a>
        </div>
        @if($sizes->isEmpty())
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
                @foreach($sizes as $size)
                    <tr>
                        <td>{{ $size->id }}</td>
                        <td>{{ $size->name }}</td>
                        <td>
                            <a href="{{ route('admin.sizes.edit', $size->id) }}" class="btn btn-sm btn-warning">Редагувати</a>
                            <form action="{{ route('admin.sizes.destroy', $size->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Ви впевнені?')">Видалити</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
