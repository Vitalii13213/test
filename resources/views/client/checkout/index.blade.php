@extends('layouts.main')

@section('content')
    <div class="container">
        <h3>Оформлення замовлення</h3>
        @auth
            @if ($cart)
                <p>Сума замовлення: {{ $total }} грн</p>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Товар</th>
                        <th>Колір</th>
                        <th>Розмір</th>
                        <th>Ціна</th>
                        <th>Кількість</th>
                        <th>Сума</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($cart as $cartKey => $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>
                                <div style="width: 20px; height: 20px; background-color: {{ $item['color_hex'] }}; border: 1px solid #ccc; display: inline-block;"></div>
                                {{ $item['color_name'] }}
                            </td>
                            <td>{{ $item['size_name'] }}</td>
                            <td>{{ $item['price'] }} грн</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>{{ $item['price'] * $item['quantity'] }} грн</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
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
                        <input type="number" name="weight" id="weight" class="form-control" value="1" step="0.1" required>
                        @error('weight')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="length" class="form-label">Довжина (см)</label>
                        <input type="number" name="length" id="length" class="form-control" value="15" required>
                        @error('length')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="width" class="form-label">Ширина (см)</label>
                        <input type="number" name="width" id="width" class="form-control" value="15" required>
                        @error('width')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="height" class="form-label">Висота (см)</label>
                        <input type="number" name="height" id="height" class="form-control" value="5" required>
                        @error('height')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Телефон</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', Auth::user()->phone ?? '') }}" required>
                        @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="full_name" class="form-label">ПІБ</label>
                        <input type="text" name="full_name" id="full_name" class="form-control" value="{{ old('full_name', Auth::user()->name ?? '') }}" required>
                        @error('full_name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">Місто</label>
                        <input type="text" name="city" id="city" class="form-control" value="{{ old('city') }}" required autocomplete="off">
                        <div id="city-suggestions" class="list-group" style="position: absolute; z-index: 1000; width: 100%;"></div>
                        @error('city')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="delivery_point" class="form-label">Відділення Нової Пошти</label>
                        <input type="text" name="delivery_point" id="delivery_point" class="form-control" value="{{ old('delivery_point') }}" required autocomplete="off">
                        <div id="delivery-point-suggestions" class="list-group" style="position: absolute; z-index: 1000; width: 100%;"></div>
                        @error('delivery_point')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Оформити замовлення</button>
                </form>
            @else
                <p>Кошик порожній.</p>
            @endif
        @else
            <p>Будь ласка, увійдіть, щоб оформити замовлення.</p>
            <a href="{{ route('login') }}" class="btn btn-primary">Увійти</a>
        @endauth
    </div>
@endsection

@section('scripts')
    <script>
        const cityInput = document.getElementById('city');
        const citySuggestions = document.getElementById('city-suggestions');
        const deliveryPointInput = document.getElementById('delivery_point');
        const deliveryPointSuggestions = document.getElementById('delivery-point-suggestions');
        let selectedCityRef = '';

        cityInput.addEventListener('input', debounce(async () => {
            const query = cityInput.value.trim();
            if (query.length < 3) {
                citySuggestions.innerHTML = '';
                return;
            }

            const response = await fetch('/api/nova-poshta/cities', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ query })
            });
            const data = await response.json();
            citySuggestions.innerHTML = '';
            if (data.success && data.data.length) {
                data.data.forEach(city => {
                    const item = document.createElement('a');
                    item.classList.add('list-group-item', 'list-group-item-action');
                    item.textContent = city.Description;
                    item.addEventListener('click', () => {
                        cityInput.value = city.Description;
                        selectedCityRef = city.Ref;
                        citySuggestions.innerHTML = '';
                        deliveryPointInput.value = '';
                    });
                    citySuggestions.appendChild(item);
                });
            }
        }, 300));

        deliveryPointInput.addEventListener('input', debounce(async () => {
            const query = deliveryPointInput.value.trim();
            if (!selectedCityRef || query.length < 1) {
                deliveryPointSuggestions.innerHTML = '';
                return;
            }

            const response = await fetch('/api/nova-poshta/warehouses', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ cityRef: selectedCityRef, query })
            });
            const data = await response.json();
            deliveryPointSuggestions.innerHTML = '';
            if (data.success && data.data.length) {
                data.data.forEach(warehouse => {
                    const item = document.createElement('a');
                    item.classList.add('list-group-item', 'list-group-item-action');
                    item.textContent = warehouse.Description;
                    item.addEventListener('click', () => {
                        deliveryPointInput.value = warehouse.Description;
                        deliveryPointSuggestions.innerHTML = '';
                    });
                    deliveryPointSuggestions.appendChild(item);
                });
            }
        }, 300));

        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }
    </script>
@endsection
