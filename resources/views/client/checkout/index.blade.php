@extends('layouts.main')

@section('title', 'Оформлення замовлення')

@section('content')
    <div class="container">
        <h3>Оформлення замовлення</h3>
        @if($cart)
            <p>Сума замовлення: {{ $total }} грн</p>
            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="shipment_description" class="form-label">Опис відправлення</label>
                    <input type="text" name="shipment_description" id="shipment_description" class="form-control" value="Одяг" readonly>
                </div>
                <div class="mb-3">
                    <label for="declared_value" class="form-label">Оголошена цінність</label>
                    <input type="number" name="declared_value" id="declared_value" class="form-control" value="{{ $total }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="weight" class="form-label">Вага (кг)</label>
                    <input type="number" name="weight" id="weight" class="form-control" value="1" step="0.1">
                </div>
                <div class="mb-3">
                    <label for="length" class="form-label">Довжина (см)</label>
                    <input type="number" name="length" id="length" class="form-control" value="20">
                </div>
                <div class="mb-3">
                    <label for="width" class="form-label">Ширина (см)</label>
                    <input type="number" name="width" id="width" class="form-control" value="20">
                </div>
                <div class="mb-3">
                    <label for="height" class="form-label">Висота (см)</label>
                    <input type="number" name="height" id="height" class="form-control" value="10">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Телефон</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', Auth::user()->phone ?? '') }}" required>
                </div>
                <div class="mb-3">
                    <label for="full_name" class="form-label">ПІБ</label>
                    <input type="text" name="full_name" id="full_name" class="form-control" value="{{ old('full_name', Auth::user()->full_name ?? '') }}" required>
                </div>
                <div class="mb-3">
                    <label for="city" class="form-label">Населений пункт</label>
                    <input type="text" name="city" id="city" class="form-control" value="{{ old('city', Auth::user()->city ?? '') }}" required>
                </div>
                <div class="mb-3">
                    <label for="delivery_point" class="form-label">Відділення Нової Пошти</label>
                    <input type="text" name="delivery_point" id="delivery_point" class="form-control" value="{{ old('delivery_point', Auth::user()->nova_poshta_branch ?? '') }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Оформити замовлення</button>
            </form>
        @else
            <p>Кошик порожній.</p>
        @endif
    </div>
@endsection
