<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController;
use App\Http\Controllers\Admin\PayrollController;
use App\Http\Controllers\Employee\DashboardController as EmployeeDashboardController;
use App\Http\Controllers\Employee\AttendanceController as EmployeeAttendanceController;
use App\Http\Controllers\Auth\LoginController; // Tetap perlu di-use jika Anda menggunakannya di route lain

// Authentication Routes
Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Employee Management
    Route::resource('employees', EmployeeController::class);

    // Attendance Management
    Route::get('/attendances/report', [AdminAttendanceController::class, 'report'])->name('attendances.report');
    Route::resource('attendances', AdminAttendanceController::class);

    // Payroll Management
    Route::get('/payrolls/payslip/{payroll}', [PayrollController::class, 'payslip'])->name('payrolls.payslip');
    Route::post('/payrolls/generate-bulk', [PayrollController::class, 'generateBulk'])->name('payrolls.generate-bulk');
    Route::post('/payrolls/{payroll}/mark-as-paid', [PayrollController::class, 'markAsPaid'])->name('payrolls.mark-as-paid');
    Route::resource('payrolls', PayrollController::class);
});

// Employee Routes
Route::prefix('employee')->name('employee.')->middleware(['auth', 'employee'])->group(function () {
    Route::get('/dashboard', [EmployeeDashboardController::class, 'index'])->name('dashboard');

    // Attendance
    Route::get('/attendances', [EmployeeAttendanceController::class, 'index'])->name('attendances.index');
    Route::post('/clock-in', [EmployeeAttendanceController::class, 'clockIn'])->name('clock-in');
    Route::post('/clock-out', [EmployeeAttendanceController::class, 'clockOut'])->name('clock-out');

    // Payroll
    Route::get('/payrolls', [EmployeeAttendanceController::class, 'payrolls'])->name('payrolls');
});