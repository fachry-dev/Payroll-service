@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Employee Sidebar -->
        <div class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse" id="sidebarCollapse">
            <div class="position-sticky pt-3">
                <!-- Employee Profile Section -->
                <div class="d-flex align-items-center justify-content-center mb-3 px-3">
                    <div class="text-center">
                        <div class="bg-light rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="bi bi-person-fill text-dark" style="font-size: 1.8rem;"></i>
                        </div>
                        <h6 class="text-white mb-0">{{ Auth::user()->name }}</h6>
                        <small class="text-white-50">{{ Auth::user()->employee->position ?? 'Employee' }}</small>
                    </div>
                </div>
                
                <hr class="text-white-50 my-2">
                
                <!-- Main Navigation -->
                <ul class="nav flex-column px-2">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('employee.dashboard') ? 'active' : '' }}" href="{{ route('employee.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    
                    <!-- Attendance Section -->
                    <li class="nav-item mt-3">
                        <span class="nav-link text-white-50 small text-uppercase fw-bold px-3 py-2">
                            Attendance
                        </span>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('employee.attendances.index') ? 'active' : '' }}" href="{{ route('employee.attendances.index') }}">
                            <i class="bi bi-calendar-check"></i> My Attendance
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('clock-in-form').submit();">
                            <i class="bi bi-box-arrow-in-right"></i> Clock In
                        </a>
                        <form id="clock-in-form" action="{{ route('employee.clock-in') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('clock-out-form').submit();">
                            <i class="bi bi-box-arrow-left"></i> Clock Out
                        </a>
                        <form id="clock-out-form" action="{{ route('employee.clock-out') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                    
                    <!-- Payroll Section -->
                    <li class="nav-item mt-3">
                        <span class="nav-link text-white-50 small text-uppercase fw-bold px-3 py-2">
                            Payroll
                        </span>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('employee.payrolls') ? 'active' : '' }}" href="{{ route('employee.payrolls') }}">
                            <i class="bi bi-cash-stack"></i> My Payroll
                        </a>
                    </li>
                </ul>
                
                <hr class="text-white-50 my-3">
                
                <!-- System Section -->
                <ul class="nav flex-column px-2">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4 content">
            <!-- Page Header -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">@yield('page-title', 'Dashboard')</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    @yield('page-actions')
                </div>
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

            <!-- Main Content Area -->
            @yield('employee-content')
        </div>
    </div>
</div>
@endsection