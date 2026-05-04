<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin System - {{ config('app.name', 'Laravel') }}</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #f3f4f6;
        }
        .sidebar {
            background-color: #272727;
            min-height: 100vh;
            color: white;
        }
        .nav-link {
            color: rgba(255,255,255,0.7);
        }
        .nav-link:hover, .nav-link.active {
            color: #85f43a;
            background-color: rgba(255,255,255,0.05);
            border-radius: 4px;
        }
        .nav-link.text-danger:hover {
            color: #ff4d4d !important;
            background-color: rgba(255,0,0,0.1);
        }
        .card-header {
            background-color: #fff;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="d-flex flex-column flex-shrink-0 p-3 sidebar" style="width: 250px;">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <span class="fs-4"><i class="bi bi-shield-lock-fill text-[#85f43a] me-2" style="color: #85f43a;"></i> Admin Panel</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    <i class="bi bi-people me-2"></i> Users
                </a>
            </li>
            <li>
                <a href="{{ route('admin.leads') }}" class="nav-link {{ request()->routeIs('admin.leads') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-spreadsheet me-2"></i> Leads Export
                </a>
            </li>
            <li>
                <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                    <i class="bi bi-gear me-2"></i> Tool Settings
                </a>
            </li>
            <li>
                <a href="{{ route('benchmarks.index') }}" class="nav-link {{ request()->routeIs('benchmarks.*') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart-line-fill me-2"></i> Industry Benchmarks
                </a>
            </li>
            <li>
                <a href="{{ route('admin.template.edit') }}" class="nav-link {{ request()->routeIs('admin.template.edit') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-code-fill me-2"></i> Report Template
                </a>
            </li>
            <hr>
            <li>
                <a href="{{ route('admin.profile') }}" class="nav-link {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                    <i class="bi bi-person-gear me-2"></i> Profile Settings
                </a>
            </li>
            <li>
                <a href="{{ route('dashboard') }}" class="nav-link text-warning">
                    <i class="bi bi-arrow-left-circle me-2"></i> Back to App
                </a>
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}" id="admin-logout-form">
                    @csrf
                    <a href="{{ route('logout') }}" class="nav-link text-danger" onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </a>
                </form>
            </li>
        </ul>
    </div>

    <!-- Content -->
    <div class="w-100 p-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
