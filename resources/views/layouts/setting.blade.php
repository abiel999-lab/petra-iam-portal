<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Settings' }}</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://my.petra.ac.id/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="https://my.petra.ac.id/adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="https://my.petra.ac.id/adminlte/dist/css/adminlte.min.css">
    <link rel="shortcut icon" href="https://login.petra.ac.id/images/favicon.png" type="image/x-icon">

    <style>
        .user-avatar-sidebar {
            width: 34px;
            height: 34px;
            object-fit: cover;
            border-radius: 50%;
            background: #f8f9fa;
        }

        .user-avatar-navbar {
            width: 28px;
            height: 28px;
            object-fit: cover;
            border-radius: 50%;
            margin-right: 6px;
            vertical-align: middle;
            background: #f8f9fa;
        }

        .sidebar-user-name {
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
@php
    $portalUser = $user ?? session('portal_user', []);
    $avatar = $portalUser['picture'] ?? null;
    $displayName = $portalUser['name'] ?? 'USER';
    $displayEmail = $portalUser['email'] ?? '-';
@endphp

<div class="wrapper">
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="https://my.petra.ac.id/img/logo.png" alt="Gate">
    </div>

    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('dashboard') }}" class="nav-link">Gate</a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto align-items-center">
            <li class="nav-item dropdown mr-2">
                <a class="nav-link btn btn-outline-secondary" data-toggle="dropdown" href="#">
                    <i class="fas fa-random"></i> {{ strtoupper($currentRole ?? 'general') }}
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <form action="{{ route('role.switch') }}" method="POST">
                        @csrf
                        @foreach(($availableRoles ?? ['general']) as $role)
                            <button
                                type="submit"
                                name="role"
                                value="{{ $role }}"
                                class="dropdown-item {{ ($currentRole ?? '') === $role ? 'active' : '' }}"
                            >
                                {{ strtoupper($role) }}
                            </button>
                        @endforeach
                    </form>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link d-flex align-items-center" data-toggle="dropdown" href="#">
                    <img
                        src="{{ $avatar ?: 'https://my.petra.ac.id/img/user.png' }}"
                        alt="User"
                        class="user-avatar-navbar"
                        onerror="this.onerror=null;this.src='https://my.petra.ac.id/img/user.png';"
                    >
                    <span>{{ strtoupper($displayName) }}</span>
                    <i class="fas fa-caret-down ml-2"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-right">
                    <a href="{{ route('setting') }}" class="dropdown-item">
                        <i class="fas fa-cog mr-2"></i> Setting
                    </a>

                    <button type="button" class="dropdown-item" onclick="confirmLogout();">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="{{ route('dashboard') }}" class="brand-link">
            <img
                src="https://my.petra.ac.id/img/logo.png"
                alt="Gate"
                class="brand-image img-circle elevation-3"
                style="opacity: .8"
            >
            <span class="brand-text font-weight-light">Gate</span>
        </a>

        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
                <div class="image">
                    <img
                        src="{{ $avatar ?: 'https://my.petra.ac.id/img/user.png' }}"
                        class="img-circle elevation-2 user-avatar-sidebar"
                        alt="{{ $displayEmail }}"
                        onerror="this.onerror=null;this.src='https://my.petra.ac.id/img/user.png';"
                    >
                </div>
                <div class="info">
                    <a href="{{ route('setting') }}" class="d-block sidebar-user-name" title="{{ $displayEmail }}">
                        {{ strtoupper($displayName) }}
                    </a>
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column">
                    <li class="nav-item">
                        <a href="{{ route('setting.profile') }}" class="nav-link {{ request()->routeIs('setting.profile') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user"></i>
                            <p>Profile</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('setting') }}" class="nav-link {{ request()->routeIs('setting') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-stopwatch"></i>
                            <p>Session</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('setting') }}" class="nav-link {{ request()->routeIs('setting') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-shield-alt"></i>
                            <p>Security</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <div class="content-wrapper">
        @if(session('success'))
            <div class="alert alert-success m-3">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger m-3">{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://my.petra.ac.id/adminlte/plugins/jquery/jquery.min.js"></script>
<script src="https://my.petra.ac.id/adminlte/plugins/jquery-ui/jquery-ui.min.js"></script>
<script>$.widget.bridge('uibutton', $.ui.button)</script>
<script src="https://my.petra.ac.id/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://my.petra.ac.id/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="https://my.petra.ac.id/adminlte/dist/js/adminlte.js"></script>
<script src="https://my.petra.ac.id/adminlte/plugins/sweetalert2/sweetalert2.min.js"></script>

<script>
    function confirmLogout() {
        Swal.fire({
            title: "Are you sure?",
            text: "You will be logged out.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, log out",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("logout-form").submit();
            }
        });
    }
</script>
</body>
</html>
