@extends('layouts.admin')

@section('title', 'Payroll Management')

@section('admin-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Payroll Management</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.payrolls.create') }}" class="btn btn-sm btn-primary me-2">
            <i class="bi bi-plus"></i> Generate Payroll
        </a>
        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#bulkPayrollModal">
            <i class="bi bi-lightning"></i> Bulk Generate
        </button>
    </div>
</div>

<!-- Bulk Payroll Modal -->
<div class="modal fade" id="bulkPayrollModal" tabindex="-1" aria-labelledby="bulkPayrollModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkPayrollModalLabel">Generate Payroll for All Employees</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.payrolls.generate-bulk') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="bulk_month" class="form-label">Month</label>
                        <select class="form-select" id="bulk_month" name="month" required>
                            <option value="01">January</option>
                            <option value="02">February</option>
                            <option value="03">March</option>
                            <option value="04">April</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="bulk_year" class="form-label">Year</label>
                        <select class="form-select" id="bulk_year" name="year" required>
                            @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <p class="text-muted">This will generate payroll for all employees who don't already have a payroll record for the selected month and year.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Generate</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">Filter Payroll</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.payrolls.index') }}" method="GET">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="employee_id" class="form-label">Employee</label>
                    <select class="form-select" id="employee_id" name="employee_id">
                        <option value="">All Employees</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="month" class="form-label">Month</label>
                    <select class="form-select" id="month" name="month">
                        <option value="">All Months</option>
                        <option value="01" {{ request('month') == '01' ? 'selected' : '' }}>January</option>
                        <option value="02" {{ request('month') == '02' ? 'selected' : '' }}>February</option>
                        <option value="03" {{ request('month') == '03' ? 'selected' : '' }}>March</option>
                        <option value="04" {{ request('month') == '04' ? 'selected' : '' }}>April</option>
                        <option value="05" {{ request('month') == '05' ? 'selected' : '' }}>May</option>
                        <option value="06" {{ request('month') == '06' ? 'selected' : '' }}>June</option>
                        <option value="07" {{ request('month') == '07' ? 'selected' : '' }}>July</option>
                        <option value="08" {{ request('month') == '08' ? 'selected' : '' }}>August</option>
                        <option value="09" {{ request('month') == '09' ? 'selected' : '' }}>September</option>
                        <option value="10" {{ request('month') == '10' ? 'selected' : '' }}>October</option>
                        <option value="11" {{ request('month') == '11' ? 'selected' : '' }}>November</option>
                        <option value="12" {{ request('month') == '12' ? 'selected' : '' }}>December</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="year" class="form-label">Year</label>
                    <select class="form-select" id="year" name="year">
                        <option value="">All Years</option>
                        @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                            <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-filter"></i> Filter
                    </button>
                    <a href="{{ route('admin.payrolls.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Employee</th>
                        <th>Period</th>
                        <th>Base Salary</th>
                        <th>Absences</th>
                        <th>Deduction</th>
                        <th>Total Salary</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payrolls as $payroll)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $payroll->employee->user->name }}</td>
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
                            <td>Rp {{ number_format($payroll->base_salary, 0, ',', '.') }}</td>
                            <td>{{ $payroll->absence_count }}</td>
                            <td>Rp {{ number_format($payroll->absence_deduction, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($payroll->total_salary, 0, ',', '.') }}</td>
                            <td>
                                @if($payroll->is_paid)
                                    <span class="badge bg-success">Paid</span>
                                @else
                                    <span class="badge bg-warning">Unpaid</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.payrolls.show', $payroll) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.payrolls.payslip', $payroll) }}" class="btn btn-sm btn-primary" target="_blank">
                                        <i class="bi bi-file-earmark-text"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No payroll records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $payrolls->links() }}
        </div>
    </div>
</div>
@endsection