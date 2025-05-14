@extends('layouts.admin')

@section('title', 'Generate Payroll')

@section('admin-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Generate Payroll</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.payrolls.index') }}" class="btn btn-sm btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Payroll
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.payrolls.store') }}" method="POST">
            @csrf
            
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="employee_id" class="form-label">Employee</label>
                    <select class="form-select @error('employee_id') is-invalid @enderror" id="employee_id" name="employee_id" required>
                        <option value="">Select Employee</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->user->name }} - {{ $employee->position }}
                            </option>
                        @endforeach
                    </select>
                    @error('employee_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="month" class="form-label">Month</label>
                    <select class="form-select @error('month') is-invalid @enderror" id="month" name="month" required>
                        @foreach($months as $key => $month)
                            <option value="{{ $key }}" {{ old('month') == $key ? 'selected' : '' }}>{{ $month }}</option>
                        @endforeach
                    </select>
                    @error('month')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label for="year" class="form-label">Year</label>
                    <select class="form-select @error('year') is-invalid @enderror" id="year" name="year" required>
                        @foreach($years as $year)
                            <option value="{{ $year }}" {{ old('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                    @error('year')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> The system will automatically calculate the salary based on the employee's base salary and attendance records for the selected month.
            </div>
            
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-calculator"></i> Generate Payroll
                </button>
            </div>
        </form>
    </div>
</div>
@endsection