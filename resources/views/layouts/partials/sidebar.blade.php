<aside class="sidebar col-md-2 d-md-block p-0">
    <div class="sidebar-header p-3 text-center">
        <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">
            <h5 class="fw-bold text-white">StyleHub Admin</h5>
        </a>
    </div>
    <ul class="nav flex-column mt-2">
        <li class="nav-item">
            <a class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-home me-2"></i> Панель управління
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Route::is('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                <i class="fas fa-tshirt me-2"></i> Товари
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Route::is('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                <i class="fas fa-list-ul me-2"></i> Категорії
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Route::is('admin.color.*') ? 'active' : '' }}" href="{{ route('admin.color.index') }}">
                <i class="fas fa-palette me-2"></i> Кольори
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Route::is('admin.sizes.*') ? 'active' : '' }}" href="{{ route('admin.sizes.index') }}">
                <i class="fas fa-ruler me-2"></i> Розміри
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Route::is('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                <i class="fas fa-shopping-cart me-2"></i> Замовлення
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="fas fa-external-link-alt me-2"></i> На сайт
            </a>
        </li>
    </ul>
</aside>

<style>
    .sidebar {
        background: #0a192f;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        overflow-y: auto;
        z-index: 1000;
    }
    .sidebar-header {
        background: #112240;
        border-bottom: 1px solid #1e3a8a;
    }
    .nav-link {
        color: #93c5fd !important;
        padding: 12px 20px !important;
        margin: 4px 10px !important;
        border-radius: 8px !important;
        transition: all 0.3s ease !important;
        font-size: 0.95rem !important;
    }
    .nav-link:hover {
        color: #fff !important;
        background: #1e40af !important;
        transform: translateY(-2px) !important;
    }
    .nav-link.active {
        color: #fff !important;
        background: #2563eb !important;
    }
    .nav-link i {
        width: 20px;
        text-align: center;
    }
    @media (max-width: 767.98px) {
        .sidebar {
            width: 200px;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }
        .sidebar.open {
            transform: translateX(0);
        }
    }
</style>

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.querySelector('.sidebar');
            const toggler = document.querySelector('.sidebar-toggler');
            if (toggler) {
                toggler.addEventListener('click', () => {
                    sidebar.classList.toggle('open');
                });
            }
        });
    </script>
@endsection
