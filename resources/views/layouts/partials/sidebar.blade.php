<nav class="admin-sidebar navbar navbar-expand navbar-dark bg-primary shadow-sm">
    <div class="container-fluid">
        <span class="navbar-brand fs-6">StyleHub Admin</span>
        <div class="collapse navbar-collapse" id="adminSidebarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}" title="Панель">
                        <i class="fas fa-tachometer-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}" title="Товари">
                        <i class="fas fa-tshirt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}" title="Замовлення">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}" title="Категорії">
                        <i class="fas fa-list"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    .admin-sidebar {
        position: sticky;
        top: 0;
        z-index: 1000;
        padding: 0;
    }
    .admin-sidebar .nav-link {
        color: #fff;
        font-size: 1.5rem;
        padding: 10px 15px;
        margin: 0 5px;
        border-radius: 5px;
        transition: transform 0.2s ease, background 0.2s ease;
    }
    .admin-sidebar .nav-link:hover {
        background: #0056b3;
        transform: scale(1.1);
    }
    .admin-sidebar .nav-link.active {
        background: #003d80;
    }
    .admin-sidebar .nav-link i {
        display: block;
        text-align: center;
    }
    @media (max-width: 767.98px) {
        .admin-sidebar .navbar-collapse {
            background: #004085;
        }
        .admin-sidebar .nav-link {
            font-size: 1.2rem;
            padding: 8px 10px;
        }
    }
</style>
