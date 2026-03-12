<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'My Petra' }}</title>

    <link rel="stylesheet" href="https://my.petra.ac.id/css/css.css">
    <link rel="stylesheet" href="https://my.petra.ac.id/adminlte/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://my.petra.ac.id/adminlte/dist/css/adminlte.min.css?v=3.2.0">
    <link rel="stylesheet" href="https://my.petra.ac.id/adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="https://my.petra.ac.id/flexbox/flexbox.css">
    <link rel="shortcut icon" href="https://login.petra.ac.id/images/favicon.png" type="image/x-icon">

    <style>
        .navbar {
            min-height: 80px !important;
            color: #6c757d;
            font-weight: bold;
            border-bottom: 3px #f8ad3d solid;
        }

        .navbar-nav .nav-link {
            color: #6c757d !important;
        }

        .thing {
            display: inline-block;
            color: #0d6efd;
            margin-right: 18px;
            margin-bottom: 12px;
            font-size: 28px;
            font-weight: 600;
            text-decoration: none;
        }

        .thing:hover {
            text-decoration: underline;
        }

        .user-avatar-navbar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            object-fit: cover;
            margin-left: 8px;
            border: 1px solid #dee2e6;
            background: #f8f9fa;
        }

        .profile-user-img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border: 3px solid #f1f1f1;
        }

        .dropdown-menu-user {
            min-width: 320px;
            padding: 0;
        }

        .dropdown-user-card {
            padding: 18px;
        }

        .role-switch-form .dropdown-item.active,
        .role-switch-form .dropdown-item:active {
            background-color: #0d6efd;
            color: #fff;
        }
    </style>
</head>
<body class="hold-transition layout-top-nav">
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
        <a href="{{ route('dashboard') }}" class="ml-2">
            <img src="https://my.petra.ac.id/img/logo.png" alt="Gate" style="width: 153px;">
        </a>

        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto align-items-center">
            <li class="nav-item dropdown mr-2">
                <a class="nav-link btn btn-outline-secondary" data-toggle="dropdown" href="#">
                    <i class="fas fa-random"></i> {{ strtoupper($currentRole ?? 'general') }}
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <form action="{{ route('role.switch') }}" method="POST" class="role-switch-form">
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
                <a class="nav-link btn btn-outline-secondary d-flex align-items-center" data-toggle="dropdown" href="#">
                    <span>{{ strtoupper($displayName) }}</span>
                    <img
                        src="{{ $avatar ?: 'https://my.petra.ac.id/img/user.png' }}"
                        alt="User"
                        class="user-avatar-navbar"
                        onerror="this.onerror=null;this.src='https://my.petra.ac.id/img/user.png';"
                    >
                </a>

                <div class="dropdown-menu dropdown-menu-right dropdown-menu-user">
                    <div class="dropdown-user-card text-center">
                        <img
                            class="profile-user-img img-fluid img-circle mb-2"
                            src="{{ $avatar ?: 'https://my.petra.ac.id/img/user.png' }}"
                            alt="User profile picture"
                            onerror="this.onerror=null;this.src='https://my.petra.ac.id/img/user.png';"
                        >

                        <h3 class="profile-username text-center mb-1">
                            {{ strtoupper($displayName) }}
                        </h3>

                        <p class="text-muted text-center mb-3">
                            {{ $displayEmail }}
                        </p>

                        <a href="{{ route('setting') }}" class="btn btn-outline-primary btn-block mb-2">
                            Manage your Account
                        </a>

                        <button type="button" class="btn btn-danger btn-block" onclick="confirmLogout();">
                            <b>Logout</b>
                        </button>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </li>
        </ul>
    </nav>

    <div class="content-wrapper">
        @if(session('success'))
            <div class="alert alert-success m-3">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger m-3">{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>

    <footer class="main-footer">
        <strong>Copyright &copy; 2026 <a href="https://petra.ac.id">Petra Christian University</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            Pusat Pengembangan Sistem Informasi <span>version: v2.0.0</span>
        </div>
    </footer>
</div>

<script src="https://my.petra.ac.id/adminlte/plugins/jquery/jquery.min.js"></script>
<script src="https://my.petra.ac.id/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://my.petra.ac.id/adminlte/dist/js/adminlte.min.js?v=3.2.0"></script>
<script src="https://my.petra.ac.id/adminlte/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="https://my.petra.ac.id/flexbox/flexbox.js"></script>

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
