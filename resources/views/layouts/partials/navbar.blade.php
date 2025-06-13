<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm col-md-10 offset-md-2 px-md-4 py-3 bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">StyleHub</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Категорії</a>
                    <ul class="dropdown-menu" aria-labelledby="categoriesDropdown">
                        @if(isset($categories) && $categories->isNotEmpty())
                            @foreach($categories as $category)
                                <li><a class="dropdown-item" href="{{ route('categories.show', $category->id) }}">{{ $category->name }}</a></li>
                            @endforeach
                        @else
                            <li><a class="dropdown-item" href="#">Немає категорій</a></li>
                        @endif
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cart.index') }}">Кошик</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user me-1"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Профіль</a></li>
                            @if(auth()->user()->is_admin)
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Адмін-панель</a></li>
                            @endif
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="p-0 m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Вийти</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Увійти</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Зареєструватися</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('auth.google') }}">Google</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

@section('scripts')
    <script>
        document.querySelectorAll('.dropdown-toggle').forEach(item => {
            item.addEventListener('click', event => {
                event.preventDefault();
                let dropdownMenu = item.nextElementSibling;
                dropdownMenu.classList.toggle('show');
            });
        });
    </script>
@endsection
