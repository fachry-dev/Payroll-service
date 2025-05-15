@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="card">
    <h1>Dashboard</h1>
    <p>Selamat datang di sistem penggajian FlexiPay.</p>
</div>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card" style="background-color: #4e73df; color: white;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Karyawan</h6>
                        <h2 class="mb-0">{{ $totalEmployees ?? 0 }}</h2>
                    </div>
                    <i class="bi bi-people fs-1"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card" style="background-color: #1cc88a; color: white;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Hadir Hari Ini</h6>
                        <h2 class="mb-0">{{ $todayPresent ?? 0 }}</h2>
                    </div>
                    <i class="bi bi-check-circle fs-1"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card" style="background-color: #e74a3b; color: white;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Tidak Hadir Hari Ini</h6>
                        <h2 class="mb-0">{{ $todayAbsent ?? 0 }}</h2>
                    </div>
                    <i class="bi bi-x-circle fs-1"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card" style="background-color: #36b9cc; color: white;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title">Total Gaji (Bulan Ini)</h6>
                        <h2 class="mb-0">Rp {{ number_format($totalSalary ?? 0, 0, ',', '.') }}</h2>
                    </div>
                    <i class="bi bi-cash fs-1"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Absensi Terbaru</h5>
                <a href="{{ route('admin.attendances.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Karyawan</th>
                                <th>Tanggal</th>
                                <th>Jam Masuk</th>
                                <th>Jam Keluar</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentAttendances ?? [] as $attendance)
                                <tr>
                                    <td>{{ $attendance->employee->user->name }}</td>
                                    <td>{{ $attendance->date->format('d M Y') }}</td>
                                    <td>{{ $attendance->clock_in ? date('H:i', strtotime($attendance->clock_in)) : '-' }}</td>
                                    <td>{{ $attendance->clock_out ? date('H:i', strtotime($attendance->clock_out)) : '-' }}</td>
                                    <td>
                                        @if($attendance->status == 'present')
                                            <span class="badge bg-success">Hadir</span>
                                        @elseif($attendance->status == 'absent')
                                            <span class="badge bg-danger">Tidak Hadir</span>
                                        @elseif($attendance->status == 'late')
                                            <span class="badge bg-warning">Terlambat</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data absensi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Karyawan Terbaru</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @forelse($recentEmployees ?? [] as $employee)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $employee->user->name }}</strong>
                                <br>
                                <small class="text-muted">{{ $employee->position }}</small>
                            </div>
                            <span class="badge bg-primary rounded-pill">{{ $employee->join_date->format('d M Y') }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-center">Tidak ada data karyawan terbaru.</li>
                    @endforelse
                </ul>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Aktivitas Terbaru</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    @forelse($recentActivities ?? [] as $activity)
                        <div class="timeline-item">
                            <div class="timeline-item-marker">
                                <div class="timeline-item-marker-text">{{ $activity->created_at->format('H:i') }}</div>
                                <div class="timeline-item-marker-indicator bg-primary"></div>
                            </div>
                            <div class="timeline-item-content">
                                {{ $activity->description }}
                                <br>
                                <small class="text-muted">{{ $activity->created_at->format('d M Y') }}</small>
                            </div>
                        </div>
                    @empty
                        <p class="text-center">Tidak ada aktivitas terbaru.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Penggajian Bulan Ini</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-4">
                    <div>
                        <h6>Total Karyawan</h6>
                        <h3>{{ $totalEmployees ?? 0 }}</h3>
                    </div>
                    <div>
                        <h6>Total Gaji</h6>
                        <h3>Rp {{ number_format($totalSalary ?? 0, 0, ',', '.') }}</h3>
                    </div>
                    <div>
                        <h6>Status</h6>
                        <h3>
                            @if(($payrollStatus ?? 'pending') == 'completed')
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-warning">Pending</span>
                            @endif
                        </h3>
                    </div>
                </div>
                <a href="{{ route('admin.payrolls.create') }}" class="btn btn-primary">Hitung Gaji Bulan Ini</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('admin.employees.create') }}" class="btn btn-primary w-100 py-3">
                            <i class="bi bi-person-plus mb-2 d-block fs-3"></i>
                            Tambah Karyawan
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('admin.attendances.create') }}" class="btn btn-success w-100 py-3">
                            <i class="bi bi-calendar-plus mb-2 d-block fs-3"></i>
                            Tambah Absensi
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('admin.payrolls.index') }}" class="btn btn-info w-100 py-3 text-white">
                            <i class="bi bi-cash-stack mb-2 d-block fs-3"></i>
                            Lihat Penggajian
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('admin.attendances.report') }}" class="btn btn-warning w-100 py-3 text-white">
                            <i class="bi bi-file-earmark-text mb-2 d-block fs-3"></i>
                            Laporan Absensi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .timeline {
        position: relative;
        padding-left: 1.5rem;
    }
    
    .timeline:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0.5rem;
        height: 100%;
        border-left: 1px solid #e3e6ec;
    }
    
    .timeline-item {
        position: relative;
        padding-bottom: 1.5rem;
    }
    
    .timeline-item-marker {
        position: absolute;
        left: -1.5rem;
        width: 1rem;
    }
    
    .timeline-item-marker-text {
        font-size: 0.75rem;
        color: #a2acba;
        margin-bottom: 0.25rem;
    }
    
    .timeline-item-marker-indicator {
        display: block;
        width: 0.75rem;
        height: 0.75rem;
        border-radius: 100%;
        background-color: #0061f2;
    }
    
    .timeline-item-content {
        padding-left: 0.75rem;
        padding-bottom: 1rem;
    }
</style>
@endsection