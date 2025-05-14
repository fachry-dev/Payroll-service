@extends('layouts.admin')

@section('title', 'Employee Details')

@section('admin-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Employee Details</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.employees.index') }}" class="btn btn-sm btn-secondary me-2">
            <i class="bi bi-arrow-left"></i> Back to Employees
        </a>
        <a href="{{ route('admin.employees.edit', $employee) }}" class="btn btn-sm btn-warning">
            <i class="bi bi-pencil"></i> Edit
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Personal Information</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th style="width: 30%">Name</th>
                        <td>{{ $employee->user->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $employee->user->email }}</td>
                    </tr>
                    <tr>
                        <th>Position</th>
                        <td>{{ $employee->position }}</td>
                    </tr>
                    <tr>
                        <th>Phone Number</th>
                        <td>{{ $employee->phone_number ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{{ $employee->address ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Join Date</th>
                        <td>{{ $employee->join_date->format('d M Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Salary Information</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th style="width: 30%">Base Salary</th>
                        <td>Rp {{ number_format($employee->base_salary, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Absence Deduction</th>
                        <td>Rp {{ number_format($employee->absence_deduction, 0, ',', '.') }} per day</td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Recent Attendance</h5>
                <a href="{{ route('admin.attendances.index', ['employee_id' => $employee->id]) }}" class="btn btn-sm btn-primary">View All</a>
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
                            @forelse($employee->attendances()->latest('date')->take(5)->get() as $attendance)
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
</div>
@endsection