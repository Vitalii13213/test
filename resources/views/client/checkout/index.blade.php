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
                        <input type="number" name="length" id="length" class="form-control" value="20" required>
                        @error('length')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="width" class="form-label">Ширина (см)</label>
                        <input type="number" name="width" id="width" class="form-control" value="20" required>
                        @error('width')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="height" class="form-label">Висота (см)</label>
                        <input type="number" name="height" id="height" class="form-control" value="10" required>
                        @error('height')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="surname" class="form-label">Прізвище</label>
                        <input type="text" name="surname" id="surname" class="form-control" value="{{ old('surname', Auth::user()->surname) }}" required>
                        @error('surname')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="first_name" class="form-label">Ім'я</label>
                        <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name', Auth::user()->first_name) }}" required>
                        @error('first_name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="patronymic" class="form-label">По батькові</label>
                        <input type="text" name="patronymic" id="patronymic" class="form-control" value="{{ old('patronymic', Auth::user()->patronymic) }}" required>
                        @error('patronymic')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Телефон</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', Auth::user()->phone) }}" required>
                        @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">Місто</label>
                        <input type="text" name="city" id="city" class="form-control" value="{{ old('city', Auth::user()->city) }}" required autocomplete="off">
                        <div id="city-suggestions" class="list-group" style="position: absolute; z-index: 1000; width: 100%;"></div>
                        @error('city')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <!-- TODO: Інтеграція API Нової Пошти для автодоповнення міст -->
                    </div>
                    <div class="mb-3">
                        <label for="delivery_type" class="form-label">Тип доставки</label>
                        <select name="delivery_type" id="delivery_type" class="form-control" required>
                            <option value="warehouse">Відділення</option>
                            <option value="postomat">Поштомат</option>
                        </select>
                        @error('delivery_type')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="delivery_point" class="form-label">Відділення/Поштомат Нової Пошти</label>
                        <input type="text" name="delivery_point" id="delivery_point" class="form-control" value="{{ old('delivery_point', Auth::user()->delivery_point) }}" required autocomplete="off">
                        <div id="delivery-point-suggestions" class="list-group" style="position: absolute; z-index: 1000; width: 100%;"></div>
                        @error('delivery_point')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <!-- TODO: Інтеграція API Нової Пошти для автодоповнення відділень/поштоматів -->
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
        // Заготовка для автодоповнення через API Нової Пошти
        const cityInput = document.getElementById('city');
        const citySuggestions = document.getElementById('city-suggestions');
        const deliveryPointInput = document.getElementById('delivery_point');
        const deliveryPointSuggestions = document.getElementById('delivery-point-suggestions');
        let selectedCityRef = '{{ Auth::user()->city_ref ?? '' }}';

        cityInput.addEventListener('input', debounce(async () => {
            const query = cityInput.value.trim();
            if (query.length < 3) {
                citySuggestions.innerHTML = '';
                return;
            }
            // TODO: Виклик API Нової Пошти для пошуку міст
            // Приклад:
            // const response = await fetch('/api/nova-poshta/cities', { ... });
            // const data = await response.json();
            // citySuggestions.innerHTML = '';
            // data.data.forEach(city => { ... });
        }, 300));

        deliveryPointInput.addEventListener('input', debounce(async () => {
            const query = deliveryPointInput.value.trim();
            if (!selectedCityRef || query.length < 1) {
                deliveryPointSuggestions.innerHTML = '';
                return;
            }
            // TODO: Виклик API Нової Пошти для пошуку відділень/поштоматів
            // Приклад:
            // const response = await fetch('/api/nova-poshta/warehouses', { ... });
            // const data = await response.json();
            // deliveryPointSuggestions.innerHTML = '';
            // data.data.forEach(warehouse => { ... });
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
