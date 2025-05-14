<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController;
use App\Http\Controllers\Admin\PayrollController;
use App\Http\Controllers\Employee\DashboardController as EmployeeDashboardController;
use App\Http\Controllers\Employee\AttendanceController as EmployeeAttendanceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication routes
Auth::routes(['register' => false]); // Disable registration

// Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Employee management
    Route::resource('employees', EmployeeController::class);
    
    // Attendance management
    Route::resource('attendances', AdminAttendanceController::class);
    Route::get('/attendance-report', [AdminAttendanceController::class, 'report'])->name('attendances.report');
    
    // Payroll management
    Route::resource('payrolls', PayrollController::class)->except(['edit', 'update', 'destroy']);
    Route::post('/payrolls/{payroll}/mark-as-paid', [PayrollController::class, 'markAsPaid'])->name('payrolls.mark-as-paid');
    Route::get('/payrolls/{payroll}/payslip', [PayrollController::class, 'generatePayslip'])->name('payrolls.payslip');
    Route::post('/payrolls/generate-bulk', [PayrollController::class, 'generateBulk'])->name('payrolls.generate-bulk');
});

// Employee routes
Route::prefix('employee')->middleware(['auth', 'employee'])->name('employee.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [EmployeeDashboardController::class, 'index'])->name('dashboard');
    
    // Attendance
    Route::get('/attendances', [EmployeeAttendanceController::class, 'index'])->name('attendances.index');
    Route::post('/clock-in', [EmployeeAttendanceController::class, 'clockIn'])->name('clock-in');
    Route::post('/clock-out', [EmployeeAttendanceController::class, 'clockOut'])->name('clock-out');
    
    // Payroll
    Route::get('/payrolls', [EmployeeDashboardController::class, 'payrolls'])->name('payrolls');
});