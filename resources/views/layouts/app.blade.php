<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Task Management')</title>

<!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('img/favicon/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('img/favicon/safari-pinned-tab.svg') }}" color="#6366f1">
    <link rel="shortcut icon" href="{{ asset('img/favicon/favicon.ico') }}">
    <meta name="msapplication-TileColor" content="#6366f1">
    <meta name="msapplication-config" content="{{ asset('img/favicon/browserconfig.xml') }}">
    <meta name="theme-color" content="#ffffff">
    <meta name="theme-color" content="#6366f1">


    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <!-- CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admindashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/userdashboard.css') }}" rel="stylesheet">
</head>
<body>
   <nav class="navbar navbar-expand-lg navbar-light bg-blur fixed-top py-3">
    <div class="container">
        <!-- Brand with gradient effect -->
        <a class="navbar-brand gradient-text fw-bold fs-4" href="#">
            <i class="bi bi-kanban me-2"></i>TaskManagement
        </a>

        <!-- Collapsible Menu -->
        <button class="navbar-toggler border-0 p-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <!-- User Profile (Add your user dropdown here if needed) -->

                <!-- Logout Button -->
                <li class="nav-item ms-lg-3">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link p-2 rounded-3 hover-scale">
                            <i class="bi bi-box-arrow-right fs-5"></i>
                            <span class="ms-2 d-none d-lg-inline">Sign Out</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    /* Custom Navbar Styles */
    .bg-blur {
        background: rgba(255, 255, 255, 0.85) !important;
        backdrop-filter: blur(12px) !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2) !important;
        box-shadow: 0 4px 24px -6px rgba(0, 0, 0, 0.1);
    }

    .gradient-text {
        background: linear-gradient(45deg, #6366f1, #3b82f6);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .hover-scale {
        transition: all 0.3s ease;
    }

    .hover-scale:hover {
        transform: translateY(-1px);
        background: rgba(99, 102, 241, 0.1) !important;
    }

    .navbar-toggler {
        transition: all 0.3s ease;
        background: rgba(99, 102, 241, 0.1);
    }

    .navbar-toggler:hover {
        background: rgba(99, 102, 241, 0.2);
    }

    .nav-link {
        color: #1f2937 !important;
        font-weight: 500;
        position: relative;
    }

    .nav-link i {
        transition: transform 0.3s ease;
    }

    .nav-link:hover i {
        transform: translateX(2px);
    }
</style>

    <div class="container mt-4">
        @yield('content')
    </div>

    <!-- Bootstrap 5 JS CDN (with Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    <!-- Custom JS (if any) -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
