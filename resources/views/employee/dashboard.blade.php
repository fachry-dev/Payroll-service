@extends('layouts.employee')

@section('title', 'Employee Dashboard')

@section('employee-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            @if(!isset($todayAttendance) || !$todayAttendance->clock_in)
                <form action="{{ route('employee.clock-in') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-success">
                        <i class="bi bi-box-arrow-in-right"></i> Clock In
                    </button>
                </form>
            @elseif(!$todayAttendance->clock_out)
                <form action="{{ route('employee.clock-out') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="bi bi-box-arrow-left"></i> Clock Out
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Today's Attendance</h5>
            </div>
            <div class="card-body">
                @if(isset($todayAttendance))
                    <div class="alert {{ $todayAttendance->status == 'present' ? 'alert-success' : ($todayAttendance->status == 'late' ? 'alert-warning' : 'alert-danger') }}">
                        <h5 class="alert-heading">
                            @if($todayAttendance->status == 'present')
                                <i class="bi bi-check-circle"></i> Present
                            @elseif($todayAttendance->status == 'late')
                                <i class="bi bi-exclamation-triangle"></i> Late
                            @else
                                <i class="bi bi-x-circle"></i> Absent
                            @endif
                        </h5>
                        <p class="mb-0">Date: {{ $todayAttendance->date->format('d M Y') }}</p>
                        <p class="mb-0">Clock In: {{ $todayAttendance->clock_in ? date('H:i', strtotime($todayAttendance->clock_in)) : 'Not yet clocked in' }}</p>
                        <p class="mb-0">Clock Out: {{ $todayAttendance->clock_out ? date('H:i', strtotime($todayAttendance->clock_out)) : 'Not yet clocked out' }}</p>
                    </div>
                @else
                    <div class="alert alert-info">
                        <h5 class="alert-heading"><i class="bi bi-info-circle"></i> No attendance record for today</h5>
                        <p class="mb-0">You haven't clocked in yet. Click the "Clock In" button to record your attendance.</p>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Recent Attendance</h5>
                <a href="{{ route('employee.attendances.index') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Clock In</th>
                                <th>Clock Out</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentAttendances as $attendance)
                                <tr>
                                    <td>{{ $attendance->date->format('d M Y') }}</td>
                                    <td>{{ $attendance->clock_in ? date('H:i', strtotime($attendance->clock_in)) : '-' }}</td>
                                    <td>{{ $attendance->clock_out ? date('H:i', strtotime($attendance->clock_out)) : '-' }}</td>
                                    <td>
                                        @if($attendance->status == 'present')
                                            <span class="badge bg-success">Present</span>
                                        @elseif($attendance->status == 'absent')
                                            <span class="badge bg-danger">Absent</span>
                                        @elseif($attendance->status == 'late')
                                            <span class="badge bg-warning">Late</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No attendance records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Monthly Attendance Summary</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="card bg-success text-white mb-3">
                            <div class="card-body">
                                <h3 class="card-title">{{ $presentCount }}</h3>
                                <p class="card-text">Present</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-warning text-white mb-3">
                            <div class="card-body">
                                <h3 class="card-title">{{ $lateCount }}</h3>
                                <p class="card-text">Late</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-danger text-white mb-3">
                            <div class="card-body">
                                <h3 class="card-title">{{ $absentCount }}</h3>
                                <p class="card-text">Absent</p>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="text-muted text-center">Current Month: {{ date('F Y') }}</p>
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Latest Payroll</h5>
                <a href="{{ route('employee.payrolls') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body">
                @if($latestPayroll)
                    <div class="alert alert-info">
                        <h5 class="alert-heading">
                            @php
                                $monthNames = [
                                    '01' => 'January',
                                    '02' => 'February',
                                    '03' => 'March',
                                    '04' => 'April',
                                    '05' => 'May',
                                    '06' => 'June',
                                    '07' => 'July',
                                    '08' => 'August',
                                    '09' => 'September',
                                    '10' => 'October',
                                    '11' => 'November',
                                    '12' => 'December'
                                ];
                            @endphp
                            {{ $monthNames[$latestPayroll->month] }} {{ $latestPayroll->year }}
                        </h5>
                        <p class="mb-0">Base Salary: Rp {{ number_format($latestPayroll->base_salary, 0, ',', '.') }}</p>
                        <p class="mb-0">Absence Deduction: Rp {{ number_format($latestPayroll->absence_deduction, 0, ',', '.') }}</p>
                        <p class="mb-0">Total Salary: Rp {{ number_format($latestPayroll->total_salary, 0, ',', '.') }}</p>
                        <p class="mb-0">Status: 
                            @if($latestPayroll->is_paid)
                                <span class="badge bg-success">Paid on {{ $latestPayroll->payment_date->format('d M Y') }}</span>
                            @else
                                <span class="badge bg-warning">Unpaid</span>
                            @endif
                        </p>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <h5 class="alert-heading"><i class="bi bi-exclamation-triangle"></i> No payroll records found</h5>
                        <p class="mb-0">There are no payroll records available for you yet.</p>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Employee Information</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th style="width: 30%">Name</th>
                        <td>{{ $employee->user->name }}</td>
                    </tr>
                    <tr>
                        <th>Position</th>
                        <td>{{ $employee->position }}</td>
                    </tr>
                    <tr>
                        <th>Join Date</th>
                        <td>{{ $employee->join_date->format('d M Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection