@if(Auth::check() && Auth::user()->is_admin)
<!-- Admin Sidebar -->
<aside class="sidebar" id="adminSidebar">
    <div class="sidebar-header">
        <h3>Admin Menu</h3>
    </div>
    <ul>
        <li>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="icon icon-dashboard"></span> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('admin.employees.index') }}" class="{{ request()->routeIs('admin.employees.*') ? 'active' : '' }}">
                <span class="icon icon-users"></span> Kelola Karyawan
            </a>
        </li>
        <li>
            <a href="{{ route('admin.attendances.index') }}" class="{{ request()->routeIs('admin.attendances.*') ? 'active' : '' }}">
                <span class="icon icon-attendance"></span> Rekap Absensi
            </a>
        </li>
        <li>
            <a href="{{ route('admin.payrolls.create') }}" class="{{ request()->routeIs('admin.payrolls.create') ? 'active' : '' }}">
                <span class="icon icon-payroll"></span> Hitung Gaji
            </a>
        </li>
        <li>
            <a href="{{ route('admin.payrolls.index') }}" class="{{ request()->routeIs('admin.payrolls.index') ? 'active' : '' }}">
                <span class="icon icon-payslip"></span> Cetak Slip Gaji
            </a>
        </li>
        <li>
            <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <span class="icon icon-profile"></span> Profil Saya
            </a>
        </li>
    </ul>
</aside>
@else
<!-- Employee Sidebar -->
<aside class="sidebar" id="employeeSidebar">
    <div class="sidebar-header">
        <h3>Karyawan Menu</h3>
    </div>
    <ul>
        <li>
            <a href="{{ route('employee.dashboard') }}" class="{{ request()->routeIs('employee.dashboard') ? 'active' : '' }}">
                <span class="icon icon-dashboard"></span> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('employee.attendances.index') }}" class="{{ request()->routeIs('employee.attendances.*') ? 'active' : '' }}">
                <span class="icon icon-attendance"></span> Absensi Saya
            </a>
        </li>
        <li>
            <a href="#" onclick="event.preventDefault(); document.getElementById('clock-in-form').submit();">
                <span class="icon icon-clock-in"></span> Presensi Masuk
            </a>
        </li>
        <li>
            <a href="#" onclick="event.preventDefault(); document.getElementById('clock-out-form').submit();">
                <span class="icon icon-clock-out"></span> Presensi Keluar
            </a>
        </li>
        <li>
            <a href="{{ route('employee.payrolls') }}" class="{{ request()->routeIs('employee.payrolls') ? 'active' : '' }}">
                <span class="icon icon-payslip"></span> Slip Gaji
            </a>
        </li>
        <li>
            <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <span class="icon icon-profile"></span> Profil Saya
            </a>
        </li>
    </ul>
    
    <form id="clock-in-form" action="{{ route('employee.clock-in') }}" method="POST" class="d-none">
        @csrf
    </form>
    <form id="clock-out-form" action="{{ route('employee.clock-out') }}" method="POST" class="d-none">
        @csrf
    </form>
</aside>
@endif
