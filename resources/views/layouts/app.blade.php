<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Payroll Service') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        /* Layout Structure */
        .app-container {
            display: flex;
            min-height: 100vh;
            position: relative;
        }

        /* Auth Pages (Login, Register) */
        .auth-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        .auth-card {
            width: 100%;
            max-width: 450px;
            padding: 2rem;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-logo {
            font-size: 2rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        /* Sidebar Styles - UPDATED WIDTH */
        .sidebar {
            width: 200px; /* Reduced from 250px */
            background-color: #2c3e50;
            color: #ecf0f1;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 15px 10px; /* Reduced horizontal padding */
            text-align: center;
            border-bottom: 1px solid #34495e;
            margin-bottom: 10px;
        }

        .sidebar-header h3 {
            margin: 0;
            font-size: 1.1em; /* Slightly smaller font */
        }

        .sidebar ul li a {
            display: flex;
            align-items: center;
            padding: 12px 15px; /* Reduced padding */
            color: #ecf0f1;
            transition: background-color 0.3s ease, padding-left 0.3s ease;
            text-decoration: none;
            font-size: 0.9rem; /* Slightly smaller font */
        }

        .sidebar ul li a .icon {
            margin-right: 8px; /* Reduced margin */
            width: 18px; /* Smaller icon width */
            text-align: center;
        }

        .sidebar ul li a:hover,
        .sidebar ul li a.active {
            background-color: #3498db;
            color: #ffffff;
            padding-left: 20px; /* Reduced indent on hover */
        }

        /* Main Content Area - UPDATED MARGIN */
        .main-content-wrapper {
            flex: 1;
            margin-left: 200px; /* Reduced from 250px to match sidebar width */
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        /* Full width for auth pages */
        .main-content-wrapper.full-width {
            margin-left: 0;
        }

        /* Navbar Styles */
        .navbar {
            background-color: #ffffff;
            color: #333;
            padding: 15px 20px; /* Reduced horizontal padding */
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            height: 60px;
            box-sizing: border-box;
            width: 100%;
        }

        .navbar .logo {
            font-size: 1.5em;
            font-weight: bold;
            color: #2c3e50;
        }

        .navbar .user-info {
            display: flex;
            align-items: center;
        }

        .navbar .user-info span {
            margin-right: 15px;
        }

        .navbar .user-info .logout-btn {
            background-color: #e74c3c;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9em;
        }

        .navbar .user-info .logout-btn:hover {
            background-color: #c0392b;
        }

        .navbar .user-info .logout-btn a {
            color: white;
            text-decoration: none;
        }

        /* Main Content */
        .main-content {
            flex-grow: 1;
            padding: 30px;
            background-color: #f4f7f6;
            overflow-y: auto;
        }

        .main-content h1 {
            margin-top: 0;
            color: #2c3e50;
        }

        /* Card Styles */
        .card {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1rem 1.25rem;
        }

        /* Mobile Toggle Button */
        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #2c3e50;
            cursor: pointer;
            padding: 0;
            margin-right: 15px;
        }

        /* Icon Placeholders */
        .icon-dashboard::before { content: "🏠"; }
        .icon-users::before { content: "👥"; }
        .icon-attendance::before { content: "📅"; }
        .icon-payroll::before { content: "💰"; }
        .icon-payslip::before { content: "📄"; }
        .icon-profile::before { content: "👤"; }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .sidebar {
                left: -200px; /* Updated to match new width */
            }

            .sidebar.active {
                left: 0;
            }

            .main-content-wrapper {
                margin-left: 0;
            }

            .sidebar-toggle {
                display: block;
            }

            .navbar {
                padding: 15px;
            }

            .navbar .user-info span {
                display: none;
            }
        }

        /* Overlay for mobile when sidebar is open */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        @media (max-width: 768px) {
            .sidebar-overlay.active {
                display: block;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    @php
        $isAuthPage = request()->is('login') || request()->is('register') || request()->is('password/*');
    @endphp

    @if($isAuthPage)
        <!-- Auth Layout (Login, Register, etc.) -->
        <div class="auth-container">
            <div class="auth-card">
                <div class="auth-header">
                    <div class="auth-logo">FlexiPay</div>
                    <p class="text-muted">Sistem Penggajian Karyawan</p>
                </div>
                
                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </div>
    @else
        <!-- Main Application Layout -->
        <div class="app-container">
            <!-- Sidebar Overlay (Mobile Only) -->
            <div class="sidebar-overlay" id="sidebarOverlay"></div>

            <!-- Include Sidebar -->
            @include('layouts.nav')

            <!-- Main Content Wrapper -->
            <div class="main-content-wrapper" id="mainContent">
                <!-- Navbar -->
                <header class="navbar">
                    <div class="d-flex align-items-center">
                        <button class="sidebar-toggle" id="sidebarToggle">
                            <i class="bi bi-list"></i>
                        </button>
                        <div class="logo">FlexiPay</div>
                    </div>
                    <div class="user-info">
                        <span id="userName">Selamat Datang, {{ Auth::user()->name ?? 'Admin User' }}!</span>
                        <button class="logout-btn">
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                        </button>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </header>

                <!-- Main Content Area -->
                <main class="main-content" id="pageContent">
                    <!-- Alert Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @yield('content')
                </main>
            </div>
        </div>
    @endif

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
            
            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);
            
            // Sidebar toggle functionality
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('adminSidebar') || document.getElementById('employeeSidebar');
            const mainContent = document.getElementById('mainContent');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            
            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                    sidebarOverlay.classList.toggle('active');
                });
            }
            
            // Close sidebar when clicking on overlay
            if (sidebarOverlay && sidebar) {
                sidebarOverlay.addEventListener('click', function() {
                    sidebar.classList.remove('active');
                    sidebarOverlay.classList.remove('active');
                });
            }
            
            // Close sidebar when window is resized to desktop size
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768 && sidebar) {
                    sidebar.classList.remove('active');
                    if (sidebarOverlay) {
                        sidebarOverlay.classList.remove('active');
                    }
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
