@extends('layouts.app')

@section('title', 'Attendance Report')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Attendance Report</h1>
        <a href="{{ route('admin.attendances.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Attendance
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Report</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.attendances.report') }}" method="GET" class="row g-3">
                <div class="col-md-5">
                    <label for="month" class="form-label">Month</label>
                    <select name="month" id="month" class="form-select">
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ $selectedMonth == $i ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-5">
                    <label for="year" class="form-label">Year</label>
                    <select name="year" id="year" class="form-select">
                        @for($i = date('Y') - 5; $i <= date('Y'); $i++)
                            <option value="{{ $i }}" {{ $selectedYear == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Generate Report</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                Attendance Report for {{ date('F', mktime(0, 0, 0, $selectedMonth, 1)) }} {{ $selectedYear }}
            </h6>
            <button onclick="window.print()" class="btn btn-sm btn-info">
                <i class="bi bi-printer"></i> Print Report
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Position</th>
                            <th>Present</th>
                            <th>Absent</th>
                            <th>Late</th>
                            <th>Total Days</th>
                            <th>Attendance Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendanceData as $data)
                            <tr>
                                <td>{{ $data['employee']->user->name }}</td>
                                <td>{{ $data['employee']->position }}</td>
                                <td>{{ $data['present'] }}</td>
                                <td>{{ $data['absent'] }}</td>
                                <td>{{ $data['late'] }}</td>
                                <td>{{ $data['total'] }}</td>
                                <td>
                                    @if($data['total'] > 0)
                                        {{ round((($data['present'] + $data['late']) / $data['total']) * 100) }}%
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No attendance data found for this period.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .sidebar, .navbar, .card-header button, form, .btn {
            display: none !important;
        }
        .main-content-wrapper {
            margin-left: 0 !important;
        }
        .card {
            box-shadow: none !important;
            border: 1px solid #ddd;
        }
    }
</style>
@endsection
