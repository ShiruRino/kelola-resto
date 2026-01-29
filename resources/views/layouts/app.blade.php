<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laundry')</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('storage/logo/logo.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
        }
        .hidden{
            display: none;
        }
        @media (min-width: 992px) {
            body {
                display: grid;
                grid-template-columns: 20% 80%;
                height: 100vh;
                overflow: hidden;
            }

            aside.sidebar {
                display: block !important;
                position: static;
                height: 100vh;
                overflow-y: auto;
                padding: 1rem;
            }

            #mobileToggleBtn {
                display: none;
            }
        }

        main.container {
            overflow-y: auto;
            height: 100vh;
            padding: 2rem;
        }

        .sidebar-brand {
            text-align: center;
            margin-bottom: 2rem;
        }

        .sidebar-brand a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 2rem;
        }

        .sidebar-brand a:hover {
            text-decoration: underline;
        }

        .nav-link {
            color: white;
            margin-bottom: 1rem;
        }

        .nav-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- Mobile Toggle Button -->
    <button class="btn btn-dark d-lg-none m-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
        <i class="bi bi-list"></i> Menu
    </button>

    <!-- Offcanvas Sidebar for Mobile -->
    <div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="mobileSidebar">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Resto</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            @include('layouts.sidebar')
        </div>
    </div>

    <!-- Sidebar (visible only on large screens) -->
    <aside class="sidebar bg-dark text-white d-none d-lg-block">
        @include('layouts.sidebar')
    </aside>

    <!-- Main Content -->
    <main class="container">
        @yield('content')
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session()->has('success'))
        Swal.fire({
        title: @json(session('success')),
        icon: "success",
        draggable: true
        });
        @endif
        @if (session()->has('error'))
        Swal.fire({
        title: @json(session('error')),
        icon: "error",
        draggable: true
        });
        @endif
        @if ($errors->any())
        Swal.fire({
        title: @json($errors->first()) {{ session()->forget('errors') }},
        icon: "error",
        draggable: true
        });
        @endif
    </script>
</body>
</html>
