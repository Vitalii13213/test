@extends('layouts.main')

@section('title', 'Кольори - Адмін')

@section('content')
    <div class="container-fluid">
        <h2>Кольори</h2>
        <div class="mb-3">
            <a href="{{ route('admin.color.create') }}" class="btn btn-primary">Додати колір</a>
        </div>
        @if($colors->isEmpty())
            <p>Кольори відсутні.</p>
        @else
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Назва</th>
                    <th>Колір</th>
                    <th>Дії</th>
                </tr>
                </thead>
                <tbody>
                @foreach($colors as $color)
                    <tr>
                        <td>{{ $color->id }}</td>
                        <td>{{ $color->name }}</td>
                        <td>
                            <span style="display: inline-block; width: 30px; height: 30px; background-color: {{ $color->hex ?? '#ffffff' }}; border: 1px solid #ddd;"></span>
                            {{ $color->hex ?? 'Немає' }}
                        </td>
                        <td>
                            <a href="{{ route('admin.color.edit', $color->id) }}" class="btn btn-sm btn-warning">Редагувати</a>
                            <form action="{{ route('admin.color.destroy', $color->id) }}" method="POST" style="display:inline;">
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
