<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/admin/dashboard') }}">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Панель</span>
            </a>
        </li>
        <li class="nav-item nav-category">Керування магазином</li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/admin/products') }}">
                <i class="menu-icon mdi mdi-tshirt-crew"></i>
                <span class="menu-title">Товари</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/admin/orders') }}">
                <i class="menu-icon mdi mdi-cart"></i>
                <span class="menu-title">Замовлення</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/admin/categories') }}">
                <i class="menu-icon mdi mdi-format-list-bulleted"></i>
                <span class="menu-title">Категорії</span>
            </a>
        </li>
        <li class="nav-item nav-category">Допомога</li>
    </ul>
</nav>
