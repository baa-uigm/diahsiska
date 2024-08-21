<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DIAHSISKA - {{ $title ?? '' }}</title>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/2.0.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/colreorder/2.0.0/css/colReorder.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/3.0.1/css/responsive.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/rowreorder/1.5.0/css/rowReorder.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/scroller/2.4.1/css/scroller.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/searchpanes/2.3.0/css/searchPanes.bootstrap5.min.css" rel="stylesheet">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/css/adminlte.min.css">
    <link rel="stylesheet" href="/css/style.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-bold text-dark" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item fw-bold" href="/logout"><i
                                    class="fa-solid fa-door-open me-1"></i>Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="/" class="brand-link">
                <img src="/images/igm.png" alt="Logo" class="brand-image" style="opacity: .8; margin-left:-2px;">
                <span class="brand-text font-weight-bold">DIAHSISKA - UIGM</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="/" class="nav-link {{ $title == 'DASHBOARD' ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-house"></i>
                                <p>
                                    DASHBOARD
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/user" class="nav-link {{ $title == 'USERS' ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-user"></i>
                                <p>
                                    USERS
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/course" class="nav-link {{ $title == 'COURSE' ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-list"></i>
                                <p>
                                    COURSE
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h1 class="m-0 fw-bold">{{ $title }}</h1>
                        </div>
                    </div>
                    <hr class="border-black">
                </div>
            </div>
            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>

        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
            reserved.
        </footer>
    </div>

    @stack('scripts')
    {{-- Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <!-- AdminLTE App -->
    <script src="/js/adminlte.min.js"></script>
</body>

</html>
