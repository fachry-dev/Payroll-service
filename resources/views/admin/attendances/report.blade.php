@extends('layouts.admin')

@section('title', 'Attendance Report')

@section('admin-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Attendance Report</h1>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">Filter Report</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.attendances.report') }}" method="GET">
            <div class="row">
                <div class="col-md-5 mb-3">
                    <label for="month" class="form-label">Month</label>
                    <select class="form-select" id="month" name="month">
                        <option value="01" {{ $selectedMonth == '01' ? 'selected' : '' }}>January</option>
                        <option value="02" {{ $selectedMonth == '02' ? 'selected' : '' }}>February</option>
                        <option value="03" {{ $selectedMonth == '03' ? 'selected' : '' }}>March</option>
                        <option value="04" {{ $selectedMonth == '04' ? 'selected' : '' }}>April</option>
                        <option value="05" {{ $selectedMonth == '05' ? 'selected' : '' }}>May</option>
                        <option value="06" {{ $selectedMonth == '06' ? 'selected' : '' }}>June</option>
                        <option value="07" {{ $selectedMonth == '07' ? 'selected' : '' }}>July</option>
                        <option value="08" {{ $selectedMonth == '08' ? 'selected' : '' }}>August</option>
                        <option value="09" {{ $selectedMonth == '09' ? 'selected' : '' }}>September</option>
                        <option value="10" {{ $selectedMonth == '10' ? 'selected' : '' }}>October</option>
                        <option value="11" {{ $selectedMonth == '11' ? 'selected' : '' }}>November</option>
                        <option value="12" {{ $selectedMonth == '12' ? 'selected' : '' }}>December</option>
                    </select>
                </div>
                <div class="col-md-5 mb-3">
                    <label for="year" class="form-label">Year</label>
                    <select class="form-select" id="year" name="year">
                        @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                            <option value="{{ $i }}" {{ $selectedYear == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-2 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-filter"></i> Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Attendance Summary for {{ date('F', mktime(0, 0, 0, $selectedMonth, 1)) }} {{ $selectedYear }}</h5>
        <button class="btn btn-sm btn-outline-secondary" onclick="window.print()">
            <i class="bi bi-printer"></i> Print Report
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Employee</th>
                        <th>Position</th>
                        <th>Present</th>
                        <th>Absent</th>
                        <th>Late</th>
                        <th>Total</th>
                        <th>Attendance Rate</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendanceData as $index => $data)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $data['employee']->user->name }}</td>
                            <td>{{ $data['employee']->position }}</td>
                            <td>{{ $data['present'] }}</td>
                            <td>{{ $data['absent'] }}</td>
                            <td>{{ $data['late'] }}</td>
                            <td>{{ $data['total'] }}</td>
                            <td>
                                @if($data['total'] > 0)
                                    {{ round(($data['present'] + $data['late']) / $data['total'] * 100) }}%
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No attendance data found for this period.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection