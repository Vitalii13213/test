<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Dashboard')</title>
    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendors/typicons/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendors/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendors/css/vendor.bundle.base.css') }}">
    <!-- Plugin CSS -->
    <link rel="stylesheet" href="{{ asset('js/select.dataTables.min.css') }}">
    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/vertical-layout-light/style.css') }}">
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}"/>
    <!-- Custom CSS to Fix Layout -->
    <style>
        .page-body-wrapper {
            min-height: 100vh;
            padding-left: 260px; /* Adjust based on sidebar width */
            transition: all 0.3s;
        }

        .sidebar-offcanvas {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            width: 260px;
            z-index: 1000;
        }

        .main-panel {
            width: 100%;
            min-height: calc(100vh - 60px); /* Adjust based on navbar height */
        }

        .content-wrapper {
            padding: 2.5rem;
        }

        @media (max-width: 991px) {
            .page-body-wrapper {
                padding-left: 0;
            }

            .sidebar-offcanvas {
                left: -260px;
            }

            .sidebar-offcanvas.active {
                left: 0;
            }
        }
    </style>
</head>
<body>
<div class="container-scroller">
    <!-- Sidebar -->
    @include('layouts2.sidebar')

    <!-- Main Content Wrapper -->
    <div class="container-fluid page-body-wrapper">
        <!-- Navbar -->
        @include('layouts2.navbar')

        <!-- Content Section -->
        <div class="main-panel">
            <div class="content-wrapper">
                @yield('content')
            </div>
            <!-- Footer -->
            <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2025 Your Company</span>
                </div>
            </footer>
        </div>
    </div>
</div>

<!-- Vendor JS -->
<script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
<!-- Plugin JS -->
<script src="{{ asset('js/select.dataTables.min.js') }}"></script>
<!-- Theme JS -->
<script src="{{ asset('js/off-canvas.js') }}"></script>
<script src="{{ asset('js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('js/template.js') }}"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
</body>
</html>
