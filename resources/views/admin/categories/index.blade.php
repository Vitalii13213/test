@extends('layouts.main')

@section('title', 'Категорії - Адмін')

@section('content')
    <div class="container-fluid">
        <h2>Категорії</h2>
        <div class="mb-3">
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Додати категорію</a>
            <a href="{{ route('admin.categories.index', ['show_inactive' => !$showInactive ? 1 : 0]) }}" class="btn btn-secondary">
                {{ $showInactive ? 'Показати лише активні' : 'Показати неактивні' }}
            </a>
        </div>
        @if($categories->isEmpty())
            <p>Категорії відсутні.</p>
        @else
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Назва</th>
                    <th>Статус</th>
                    <th>Дії</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            <span class="badge {{ $category->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $category->is_active ? 'Активна' : 'Неактивна' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-warning">Редагувати</a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;">
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
