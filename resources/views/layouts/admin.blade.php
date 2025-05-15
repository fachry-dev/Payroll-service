@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse " id="sidebarCollapse">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    
                    <!-- Employee Management -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}" href="{{ route('admin.employees.index') }}">
                            <i class="bi bi-people"></i> Employees
                        </a>
                    </li>
                    
                    <!-- Attendance Management -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.attendances.index') || request()->routeIs('admin.attendances.create') || request()->routeIs('admin.attendances.edit') ? 'active' : '' }}" href="{{ route('admin.attendances.index') }}">
                            <i class="bi bi-calendar-check"></i> Attendance
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.attendances.report') ? 'active' : '' }}" href="{{ route('admin.attendances.report') }}">
                            <i class="bi bi-file-earmark-text"></i> Attendance Report
                        </a>
                    </li>
                    
                    <!-- Payroll Management -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.payrolls.*') ? 'active' : '' }}" href="{{ route('admin.payrolls.index') }}">
                            <i class="bi bi-cash-stack"></i> Payroll
                        </a>
                    </li>
                    
                    <!-- Quick Actions -->
                    <li class="nav-item mt-4">
                        <span class="nav-link text-muted small text-uppercase">Quick Actions</span>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.employees.create') }}">
                            <i class="bi bi-person-plus"></i> Add Employee
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.attendances.create') }}">
                            <i class="bi bi-calendar-plus"></i> Add Attendance
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.payrolls.create') }}">
                            <i class="bi bi-calculator"></i> Generate Payroll
                        </a>
                    </li>
                    
                    <!-- Logout -->
                    <li class="nav-item mt-4">
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
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('admin-content')
        </div>
    </div>
</div>
@endsection