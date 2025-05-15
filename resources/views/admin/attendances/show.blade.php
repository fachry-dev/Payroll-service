@extends('layouts.app')

@section('title', 'Attendance Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Attendance Details</h1>
        <div>
            <a href="{{ route('admin.attendances.edit', $attendance->id) }}" class="btn btn-primary">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('admin.attendances.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Attendance Information</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Employee</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $attendance->employee->user->name }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-person fs-2 text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Date</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $attendance->date->format('d M Y') }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-calendar-date fs-2 text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Clock In</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $attendance->clock_in ?? 'Not Recorded' }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-clock fs-2 text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Clock Out</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $attendance->clock_out ?? 'Not Recorded' }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-clock-history fs-2 text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Status</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        @if($attendance->status == 'present')
                                            <span class="badge bg-success">Present</span>
                                        @elseif($attendance->status == 'absent')
                                            <span class="badge bg-danger">Absent</span>
                                        @elseif($attendance->status == 'late')
                                            <span class="badge bg-warning">Late</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-check-circle fs-2 text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card border-left-secondary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                        Created At</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $attendance->created_at->format('d M Y H:i') }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-clock-history fs-2 text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Notes</h6>
                </div>
                <div class="card-body">
                    {{ $attendance->notes ?? 'No notes available.' }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
