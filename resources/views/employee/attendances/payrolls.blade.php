@extends('layouts.employee')

@section('title', 'My Payroll')

@section('employee-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">My Payroll</h1>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Period</th>
                        <th>Base Salary</th>
                        <th>Absences</th>
                        <th>Deduction</th>
                        <th>Total Salary</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payrolls as $payroll)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
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
                                    <span class="badge bg-success">Paid on {{ $payroll->payment_date->format('d M Y') }}</span>
                                @else
                                    <span class="badge bg-warning">Unpaid</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No payroll records found.</td>
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