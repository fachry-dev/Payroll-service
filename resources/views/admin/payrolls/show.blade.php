@extends('layouts.admin')

@section('title', 'Payroll Details')

@section('admin-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Payroll Details</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.payrolls.index') }}" class="btn btn-sm btn-secondary me-2">
            <i class="bi bi-arrow-left"></i> Back to Payroll
        </a>
        <a href="{{ route('admin.payrolls.payslip', $payroll) }}" class="btn btn-sm btn-primary me-2" target="_blank">
            <i class="bi bi-file-earmark-text"></i> View Payslip
        </a>
        @if(!$payroll->is_paid)
            <form action="{{ route('admin.payrolls.mark-as-paid', $payroll) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm btn-success">
                    <i class="bi bi-check-circle"></i> Mark as Paid
                </button>
            </form>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Employee Information</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th style="width: 30%">Name</th>
                        <td>{{ $payroll->employee->user->name }}</td>
                    </tr>
                    <tr>
                        <th>Position</th>
                        <td>{{ $payroll->employee->position }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $payroll->employee->user->email }}</td>
                    </tr>
                    <tr>
                        <th>Join Date</th>
                        <td>{{ $payroll->employee->join_date->format('d M Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Payroll Information</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th style="width: 30%">Period</th>
                        <td>
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
                            {{ $monthNames[$payroll->month] }} {{ $payroll->year }}
                        </td>
                    </tr>
                    <tr>
                        <th>Base Salary</th>
                        <td>Rp {{ number_format($payroll->base_salary, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Absence Count</th>
                        <td>{{ $payroll->absence_count }} days</td>
                    </tr>
                    <tr>
                        <th>Absence Deduction</th>
                        <td>Rp {{ number_format($payroll->absence_deduction, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Total Salary</th>
                        <td class="fw-bold">Rp {{ number_format($payroll->total_salary, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($payroll->is_paid)
                                <span class="badge bg-success">Paid on {{ $payroll->payment_date->format('d M Y') }}</span>
                            @else
                                <span class="badge bg-warning">Unpaid</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Attendance Details</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Clock In</th>
                        <th>Clock Out</th>
                        <th>Status</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $attendance)
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
                            <td>{{ $attendance->notes ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No attendance records found for this period.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection